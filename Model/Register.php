<?php

namespace Springbot\Main\Model;

use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Springbot\Main\Helper\Data;
use Magento\Sales\Model\Order\Config as OrderConfig;

/**
 * Class Register
 * @package Springbot\Main\Model
 */
class Register extends AbstractModel
{
    const API_CLASS = 'stores';

    private $_api;
    private $_helper;
    private $_config;
    private $_orderConfig;
    private $_scopeConfigInterface;
    private $_storeManager;
    private $_urlInterface;

    /**
     * @param Api $api
     * @param Config $config
     * @param Context $context
     * @param Data $data
     * @param OrderConfig $orderConfig
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfigInterface
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        Api $api,
        Config $config,
        Context $context,
        Data $data,
        OrderConfig $orderConfig,
        Registry $registry,
        ScopeConfigInterface $scopeConfigInterface,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface
    ) {
        $this->_api = $api;
        $this->_config = $config;
        $this->_scopeConfigInterface = $scopeConfigInterface;
        $this->_helper = $data;
        $this->_orderConfig = $orderConfig;
        $this->_storeManager = $storeManager;
        $this->_urlInterface = $urlInterface;
        parent::__construct($context, $registry);
    }

    /**
     * Register all stores with Springbot via the ETL.
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function registerStores($email, $password)
    {
        try {
            $url = $this->_api->getApiUrl(Api::STORE_REGISTRATION_URL);
            $storesArray = $this->getStoresArray();
            $response = $this->_api->post($url, json_encode([
                'stores' => $this->getStoresArray(),
                'credentials' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]));

            if ($responseArray = json_decode($response->getBody(), true)) {
                foreach ($storesArray as $guid => $storeArray) {
                    if ($returnedStoreArray = $responseArray['stores'][$guid]) {
                        $vars = [
                            'store_guid' => $guid,
                            'store_id' => $returnedStoreArray['springbot_store_id'],
                            'security_token' => $returnedStoreArray['security_token']
                        ];
                        $this->commitVars($vars);
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
    public function getStoresArray()
    {
        $storesArray = [];
        foreach ($this->_storeManager->getStores() as $store) {

            $guid = $this->_helper->getStoreGuid();
            $storesArray[$guid] = [
                'guid' => $guid,
                'url' => $store->getBaseUrl(),
                'name' => $store->getName(),
                'logo_src' => $this->_scopeConfigInterface->getValue('design/header/logo_src'),
                'logo_alt_tag' => $this->_scopeConfigInterface->getValue('design/header/logo_atl'),
                'web_id' => $store->getWebsiteId(),
                'store_id' => $this->getId(),
                'store_name' => $store->getName(),
                'store_code' => $store->getCode(),
                'store_active' => $store->getIsActive(),
                'store_url' => $store->getBaseUrl(),
                'media_url' => $this->_urlInterface->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
                'store_mail_address' => $this->_getStoreAddress(),
                'store_custsrv_email' => $this->_scopeConfigInterface->getValue('trans_email/ident_support/email'),
                'store_statuses' => $this->_orderConfig->getStatuses()
            ];
        }
        return $storesArray;
    }

    /**
     * Takes an associative array of variables which will be
     *
     * @param array $vars
     */
    protected function commitVars($vars)
    {
        foreach ($vars as $key => $value) {
            $configKey = $this->makeConfigKey($key, $this->_storeManager->getStore()->getId());
            $this->_config->saveConfig($configKey, $value, 'default', 0);
        }
    }

    protected function _getStoreAddress()
    {
        return str_replace(array("\n", "\r"), "|", $this->_scopeConfigInterface->getValue('general/store_information/address'));
    }

    protected function makeConfigKey($dataClass, $storeId = '')
    {
        $configKey = 'springbot/configuration/' . $dataClass;
        if ($storeId != '') {
            $configKey = $configKey . '_' . $storeId;
        }

        return $configKey;
    }
}
