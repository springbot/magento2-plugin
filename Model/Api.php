<?php

namespace Springbot\Main\Model;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Helper\Data;

/**
 * Class Api
 * @package Springbot\Main\Model
 */
class Api extends AbstractModel
{
    const ETL_URL = 'http://localhost:8080/';
    const ETL_API_PATH = 'api/';
    const WEBHOOKS_PATH = 'webhooks/v1';
    const STORE_REGISTRATION_URL = 'webhooks/v1/stores';

    const SUCCESSFUL_RESPONSE = 'ok';
    const HTTP_CONTENT_TYPE = 'Content-type: application/json';
    const TOTAL_POST_FAIL_LIMIT = 32;
    const RETRY_LIMIT = 3;

    private $_springbotHelper;
    private $_scopeConfig;
    private $_client;
    private $_encrypt;

    /**
     * Api constructor.
     * @param Data $springbotHelper
     * @param EncryptorInterface $encryptorInterface
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Data $springbotHelper,
        EncryptorInterface $encryptorInterface,
        ScopeConfigInterface $scopeConfig,
        Context $context,
        Registry $registry
    ) {
        $this->_encrypt = $encryptorInterface;
        $this->_springbotHelper = $springbotHelper;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $registry);
    }

    /**
     * @return EncryptorInterface
     */
    public function encryptor()
    {
        return $this->_encrypt;
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
     */
    public function postEntities($storeId, $apiPath, $entitiesName, array $entitiesData)
    {
        // TODO: Get springbot_store_id and api_token from store_id
        /*
        $body = json_encode([$entitiesName => $entitiesData]);
        $headers = [
            'X-AUTH-TOKEN' => $apiToken,
            'Content-Type' => 'application/json'
        ];
        return $this->post($this->getApiUrl('v1') . $springbotStoreId . "/{$apiPath}", $body, $headers);
        */
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
        $this->_client->setHeaders(self::HTTP_CONTENT_TYPE);
        return $this->_client;
    }

    /**
     * @param string $subpath
     * @return string
     */
    public function getApiUrl($subpath = '')
    {
        $url = self::ETL_URL . self::ETL_API_PATH;
        if ($subpath) {
            $url .= $subpath . '/';
        }
        return $url;
    }
}
