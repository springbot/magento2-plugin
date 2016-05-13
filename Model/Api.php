<?php

namespace Springbot\Main\Model;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Helper\Data;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class Api
 *
 * @package Springbot\Main\Model
 */
class Api extends AbstractModel
{
    const ETL_API_PATH = 'api/';
    const WEBHOOKS_PATH = 'webhooks/v1';
    const STORE_REGISTRATION_URL = self::WEBHOOKS_PATH . '/stores';

    const SUCCESSFUL_RESPONSE = 'ok';
    const TOTAL_POST_FAIL_LIMIT = 32;
    const RETRY_LIMIT = 3;

    private $_springbotHelper;
    private $_scopeConfig;
    private $_storeConfig;
    private $_client;

    /**
     * Api constructor.
     * @param Data $springbotHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreConfiguration $storeConfig
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Data $springbotHelper,
        ScopeConfigInterface $scopeConfig,
        StoreConfiguration $storeConfig,
        Context $context,
        Registry $registry
    ) {
        $this->_springbotHelper = $springbotHelper;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeConfig = $storeConfig;
        parent::__construct($context, $registry);
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
     * @param $entitiesName
     * @param array $entitiesData
     * @throws \Exception
     */
    public function postEntities($storeId, $apiPath, $entitiesName, array $entitiesData)
    {
        $springbotStoreId = $this->_storeConfig->getSpringbotStoreId($storeId);
        $springbotApiToken = $this->_storeConfig->getApiToken($storeId);
        if ($springbotStoreId && $springbotApiToken) {
            $body = json_encode([$entitiesName => $entitiesData]);
            $this->post($this->getApiUrl('v1') . "/{$springbotStoreId}/{$apiPath}", $body, $this->_getAuthHeaders($springbotApiToken));
        }
    }

    /**
     * @param $storeId
     * @param $apiPath
     * @param $entitiesName
     * @param $entityId
     * @throws \Exception
     */
    public function deleteEntity($storeId, $apiPath, $entitiesName, $entityId)
    {
        $springbotStoreId = $this->_storeConfig->getSpringbotStoreId($storeId);
        $springbotApiToken = $this->_storeConfig->getApiToken($storeId);
        if ($springbotStoreId && $springbotApiToken) {
            $body = json_encode([$entitiesName => ['id' => $entityId, 'is_deleted' => true]]);
            $this->post($this->getApiUrl('v1') . "/{$springbotStoreId}/{$apiPath}", $body, $this->_getAuthHeaders($springbotApiToken));
        }
    }

    /**
     * @param $apiToken
     * @return array
     */
    private function _getAuthHeaders($apiToken)
    {
        return [
            'X-AUTH-TOKEN' => $apiToken,
            'Content-Type' => 'application/json'
        ];
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
        $this->_client = new \Zend_Http_Client();
        $this->_client->setMethod($method);
        return $this->_client;
    }

    /**
     * @param string $subpath
     * @return string
     */
    public function getApiUrl($subpath = '')
    {
        $url = $this->_scopeConfig->getValue('springbot/configuration/api_url') . '/' . self::ETL_API_PATH;
        if ($subpath) {
            $url .= '/' . $subpath;
        }
        return $url;
    }
}
