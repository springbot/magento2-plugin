<?php

namespace Springbot\Main\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
use Springbot\Main\Helper\Data as SpringbotHelper;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class ViewPixel extends AbstractProduct
{

    protected $springbotHelper;
    protected $scopeConfig;
    protected $urlInterface;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        SpringbotHelper $springbotHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->springbotHelper = $springbotHelper;
        $this->urlInterface = ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        parent::__construct($context);
    }

    /**
     * Return the URL to the Magento2 API (ETL)
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->scopeConfig->getValue('springbot/configuration/api_url');
    }

    public function getCurrentUrl()
    {
        return $this->urlInterface->getCurrentUrl();
    }

    /**
     * Return the URL to the Magento2 API (ETL)
     *
     * @return string
     */
    public function getSku()
    {
        if ($product = $this->getProduct()) {
            return $product->getSku();
        } else {
            return '';
        }
    }

    /**
     * Get the GUID for the async code
     *
     * @return string
     */
    public function getStoreGuid()
    {
        return strtolower($this->springbotHelper->getStoreGuid());
    }
}
