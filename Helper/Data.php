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

    private $config;
    private $storeManager;

    /**
     * Data constructor.
     *
     * @param Context               $context
     * @param Config                $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Config $config,
        StoreManagerInterface $storeManager
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Check for GUID and if not found, generate it.
     *
     * @return string
     */
    public function getStoreGuid($storeId)
    {
        $store = $this->storeManager->getStore($storeId);

        $guid = $this->scopeConfig
            ->getValue('springbot/configuration/store_guid_' . $storeId);

        if (empty($guid)) {
            $baseUrl = $this->scopeConfig->getValue('web/unsecure/base_url');

            $charid = strtoupper(hash('sha256', $baseUrl . $storeId . $store->getName() . $store->getCode()));

            $guid = substr($charid, 0, 8)  . '-'
                  . substr($charid, 8, 4)  . '-'
                  . substr($charid, 12, 4) . '-'
                  . substr($charid, 16, 4) . '-'
                  . substr($charid, 20, 12);
        }
        return $guid;
    }
}
