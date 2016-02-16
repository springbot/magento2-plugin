<?php

namespace Springbot\Main\Helper;

use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Data
 *
 * @package Springbot\Main\Helper
 */
class Data extends AbstractHelper
{
    const SPRINGBOT_REGISTRATION_URL = 'https://api.springbot.com/api/registration/login/';

    /**
     * @var Config
     */
    private $_config;
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Config $config,
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->_config = $config;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Check for GUID and if not found, generate it.
     *
     * @return string
     */
    public function getStoreGuid()
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $guid = $this->scopeConfig->getValue('springbot/configuration/store_guid_' . $storeId);
        if (empty($guid)) {
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $guid = substr($charid, 0, 8) . '-'
                . substr($charid, 8, 4) . '-'
                . substr($charid, 12, 4) . '-'
                . substr($charid, 16, 4) . '-'
                . substr($charid, 20, 12);
            $this->_config->saveConfig('springbot/configuration/store_guid_' . $storeId, $guid, 'default', 0);
        }
        return str_replace('-', '', $guid);
    }
}
