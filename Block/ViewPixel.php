<?php

namespace Springbot\Main\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
use Springbot\Main\Helper\Data as SpringbotHelper;
use Magento\Framework\UrlInterface;

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
     * @param Context $context
     * @param SpringbotHelper $springbotHelper
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        Context $context,
        SpringbotHelper $springbotHelper,
        UrlInterface $urlInterface
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->springbotHelper = $springbotHelper;
        $this->urlInterface = $urlInterface;
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
        return str_replace('-', '', strtolower($this->springbotHelper->getStoreGuid()));
    }
}
