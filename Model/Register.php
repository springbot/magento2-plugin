<?php

namespace Springbot\Main\Model;

use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Config as OrderConfig;
use Springbot\Main\Helper\Data;

/**
 * Class Register
 *
 * @package Springbot\Main\Model
 */
class Register extends AbstractModel
{
    const API_CLASS = 'stores';

    private $_api;
    private $_helper;
    private $_orderConfig;
    private $_storeManager;
    private $_urlInterface;
    private $_storeConfig;
    private $_scopeConfigInterface;
    private $_oauth;

    /**
     * @param Api $api
     * @param Context $context
     * @param Data $data
     * @param OrderConfig $orderConfig
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfigInterface
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $urlInterface
     * @param StoreConfiguration $storeConfig
     * @param Oauth $oauth;
     */
    public function __construct(
        Api $api,
        Context $context,
        Data $data,
        OrderConfig $orderConfig,
        Registry $registry,
        ScopeConfigInterface $scopeConfigInterface,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        StoreConfiguration $storeConfig,
        Oauth $oauth
    ) {
        $this->_api = $api;
        $this->_scopeConfigInterface = $scopeConfigInterface;
        $this->_helper = $data;
        $this->_orderConfig = $orderConfig;
        $this->_storeManager = $storeManager;
        $this->_urlInterface = $urlInterface;
        $this->_storeConfig = $storeConfig;
        $this->_oauth = $oauth;
        parent::__construct($context, $registry);
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function registerAllStores($email, $password)
    {
        $stores = $this->_storeManager->getStores();
        return $this->registerStores($email, $password, $stores);
    }

    /**
     * Register all stores with Springbot via the ETL.
     *
     * @param $email
     * @param $password
     * @param \Magento\Store\Api\Data\StoreInterface[]
     * @return bool
     */
    public function registerStores($email, $password, $stores)
    {
        try {
            $url = $this->_api->getApiUrl(Api::STORE_REGISTRATION_PATH);
            $storesArray = $this->getStoresArray($stores);

            $response = $this->_api->post($url, json_encode([
                'stores' => $storesArray,
                'access_token' => $this->_oauth->create(),
                'credentials' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]));

            if ($responseArray = json_decode($response->getBody(), true)) {
                $securityToken = $responseArray['security_token'];
                foreach ($storesArray as $guid => $storeArray) {
                    if ($returnedStoreArray = $responseArray['stores'][$guid]) {
                        $this->_storeConfig->saveValues($returnedStoreArray['store_id'], [
                            'store_guid' => $guid,
                            'store_id' => $returnedStoreArray['springbot_store_id'],
                            'security_token' => $securityToken
                        ]);
                    }
                }

                $this->_cacheManager->clean();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns an array of all stores on the instance with the necessary data to register the store with Springbot.
     *
     * @return array
     */
    public function getStoresArray($stores)
    {
        $storesArray = [];
        foreach ($stores as $store) {
            $guid = $this->_helper->getStoreGuid();
            $storesArray[$guid] = [
                'guid' => $guid,
                'url' => $store->getBaseUrl(),
                'name' => $store->getName(),
                'logo_src' => $this->_scopeConfigInterface->getValue('design/header/logo_src'),
                'logo_alt_tag' => $this->_scopeConfigInterface->getValue('design/header/logo_atl'),
                'web_id' => $store->getWebsiteId(),
                'store_id' => $store->getId(),
                'store_name' => $store->getName(),
                'store_code' => $store->getCode(),
                'store_active' => $store->getIsActive(),
                'store_url' => $store->getBaseUrl(),
                'media_url' => $this->_urlInterface->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
                'store_mail_address' => $this->_getStoreAddress(),
                'store_custsrv_email' => $this->_scopeConfigInterface->getValue('trans_email/ident_support/email'),
                'store_statuses' => $this->_orderConfig->getStatuses(),
            ];
        }
        return $storesArray;
    }

    protected function _getStoreAddress()
    {
        return str_replace(["\n", "\r"], "|", $this->_scopeConfigInterface->getValue('general/store_information/address'));
    }
}
