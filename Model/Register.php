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
     * @param Data $data
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
     * @return Api
     */
    public function api()
    {
        return $this->_api;
    }

    /**
     * Register all stores with the Springbot app
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function registerStores($email, $password)
    {
        try {
            $guid = $this->_helper->getStoreGuid();
            $url = $this->api()->getApiUrl(Api::STORE_REGISTRATION_URL);
            $response = $this->api()->post($url, json_encode([
                'credentials' => [
                    'email' => $email,
                    'password' => $password
                ],
                'store' => $this->getStoreArray($guid)
            ]));

            if ($responseArray = json_decode($response->getBody(), true)) {
                $springbotStoreId = array_search($guid, $response['stores']);
                $vars = [
                    'store_guid' => $guid,
                    'store_id' => $springbotStoreId,
                    'security_token' => $this->_scopeConfigInterface->getValue('springbot/configuration/security_token')
                ];

                $this->commitVars($vars);
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
     * @param $guid
     * @return array
     */
    public function getStoreArray($guid)
    {
        $storeUrl = $this->_scopeConfigInterface->getValue('web/unsecure/base_url');
        $store = $this->_storeManager->getStore();

        return [
            'guid' => $guid,
            'url' => $storeUrl,
            'name' => $store->getName(),
            'logo_src' => $this->_scopeConfigInterface->getValue('design/header/logo_src'),
            'logo_alt_tag' => $this->_scopeConfigInterface->getValue('design/header/logo_atl'),
            'web_id' => $store->getWebsiteId(),
            'store_id' => $this->getId(),
            'store_name' => $store->getName(),
            'store_code' => $store->getCode(),
            'store_active' => $store->getIsActive(),
            'store_url' => $storeUrl,
            'media_url' => $this->_urlInterface->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA),
            'store_mail_address' => $this->_getStoreAddress(),
            'store_custsrv_email' => $this->_scopeConfigInterface->getValue('trans_email/ident_support/email'),
            'store_statuses' => $this->_orderConfig->getStatuses()
        ];
    }

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
