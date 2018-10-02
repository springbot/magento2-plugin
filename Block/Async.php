<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class Async extends Template
{

    protected $springbotHelper;
    protected $scopeConfig;
    protected $storeManager;

    /**
     * @param Context         $context
     * @param SpringbotHelper $springbotHelper
     * @param StoreManager    $storeManager
     */
    public function __construct(
        Context $context,
        SpringbotHelper $springbotHelper
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->springbotHelper = $springbotHelper;
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context);
    }

    /**
     * Default domain that serves our JS script
     *
     * @return string
     */
    public function getAssetsDomain()
    {
        return $this->scopeConfig->getValue('springbot/configuration/assets_domain');
    }

    /**
     * Return the GUID for the current store
     *
     * @return string
     */
    public function getStoreGuid()
    {
        $guid = $this->springbotHelper->getStoreGuid($this->storeManager->getStore()->getId());

        return str_replace('-', '', strtolower($guid));
    }
}
