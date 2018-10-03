<?php

namespace Springbot\Main\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Springbot\Main\Helper\Data;

/**
 * Class Api
 *
 * @package Springbot\Main\Model
 */
class Api
{
    const etl_webhooks_path = 'magento2/webhooks/v1';
    const store_registration_path = 'magento2/create';

    const successful_response = 'ok';
    const total_post_fail_limit = 32;
    const retry_limit = 3;

    private $springbotHelper;
    private $scopeConfig;
    private $storeConfig;
    private $client;

    /**
     * Api constructor.
     *
     * @param Data                 $springbotHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreConfiguration   $storeConfig
     */
    public function __construct(
        Data $springbotHelper,
        ScopeConfigInterface $scopeConfig,
        StoreConfiguration $storeConfig
    ) {
        $this->springbotHelper = $springbotHelper;
        $this->scopeConfig = $scopeConfig;
        $this->storeConfig = $storeConfig;
    }

    /**
     * @param $url
     * @param $body
     * @param array $headers
     * @return \Zend_Http_Response
     * @throws \Exception
     * @throws \Zend_Http_Client_Exception
     */
    public function post($url, $body, $headers = ['Content-Type' => 'application/json'])
    {
        try {
            return $this->getClient(\Zend_Http_Client::POST)
                ->setUri($url)
                ->setHeaders($headers)
                ->setRawData($body)
                ->request();
        } catch (\Exception $e) {
            throw new \Exception("HTTP POST failed with code: {$e->getMessage()}");
        }
    }

    /**
     * @param $storeId
     * @param $apiPath
     * @param array   $entitiesData
     * @throws \Exception
     */
    public function postEntities($storeId, $apiPath, array $entitiesData)
    {
        $springbotStoreId = $this->storeConfig->getSpringbotStoreId($storeId);
        $springbotApiToken = $this->storeConfig->getApiToken($storeId);
        if ($springbotStoreId && $springbotApiToken) {
            $body = json_encode($entitiesData);
            $url = $this->getWebhooksUrl("{$springbotStoreId}/{$apiPath}");
            $this->post($url, $body, $this->getAuthHeaders($springbotApiToken));
        }
    }

    /**
     * @param $storeId
     * @param $apiPath
     * @param $entityId
     * @throws \Exception
     */
    public function deleteEntity($storeId, $apiPath, $entityId)
    {
        $springbotStoreId = $this->storeConfig->getSpringbotStoreId($storeId);
        $springbotApiToken = $this->storeConfig->getApiToken($storeId);
        if ($springbotStoreId && $springbotApiToken) {
            $body = json_encode([$apiPath => ['id' => $entityId, 'is_deleted' => true]]);
            $this->post(
                $this->getApiUrl('v1') . "/{$springbotStoreId}/{$apiPath}",
                $body,
                $this->getAuthHeaders($springbotApiToken)
            );
        }
    }

    /**
     * @param $url
     * @param array $headers
     * @return \Zend_Http_Response
     * @throws \Exception
     * @throws \Zend_Http_Client_Exception
     */
    public function get($url, $headers = [])
    {
        $client = $this->getClient(\Zend_Http_Client::POST)
            ->setUri($url)
            ->setHeaders($headers);
        try {
            return $client->request();
        } catch (\Exception $e) {
            throw new \Exception("HTTP GET failed with code: {$e->getMessage()}");
        }
    }

    /**
     * @param string $method
     * @return \Zend_Http_Client
     * @throws \Zend_Http_Client_Exception
     */
    public function getClient($method = \Zend_Http_Client::POST)
    {
        $this->client = new \Zend_Http_Client();
        $this->client->setMethod($method);
        $this->client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
        return $this->client;
    }

    /**
     * @return string
     */
    public function getAppUrl()
    {
        return $this->scopeConfig->getValue('springbot/configuration/app_url');
    }

    /**
     * @param string $subpath
     * @return string
     */
    public function getApiUrl($subpath = '')
    {
        $url = $this->scopeConfig->getValue('springbot/configuration/api_url');
        if ($subpath) {
            $url .= '/' . $subpath;
        }
        return $url;
    }

    /**
     * @param string $subpath
     * @return string
     */
    public function getWebhooksUrl($subpath = '')
    {
        $url = $this->scopeConfig->getValue('springbot/configuration/api_url') . '/' . self::etl_webhooks_path;
        if ($subpath) {
            $url .= '/' . $subpath;
        }
        return $url;
    }

    /**
     * @param string $subpath
     * @return string
     */
    public function getGuestOffset()
    {
        return $this->scopeConfig->getValue('springbot/configuration/guest_offset');
    }

    /**
     * @param $apiToken
     * @return array
     */
    private function getAuthHeaders($apiToken)
    {
        return [
            'X-AUTH-TOKEN' => $apiToken,
            'Content-Type' => 'application/json'
        ];
    }
}
