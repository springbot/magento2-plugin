<?php

namespace Springbot\Main\Block;

use Magento\Framework\UrlInterface;
use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Stdlib\ArrayUtils;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class ViewPixel extends AbstractView
{

    protected $springbotHelper;
    protected $scopeConfig;
    protected $storeManager;

    /* @var UrlInterface $urlInterface */
    protected $urlInterface;

    /**
     * ViewPixel constructor.
     *
     * @param Context         $context
     * @param ArrayUtils      $arrayUtils
     * @param array           $data
     * @param SpringbotHelper $springbotHelper
     * @param StoreManager    $storeManager
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        array $data = [],
        SpringbotHelper $springbotHelper
    ) {
        $this->springbotHelper = $springbotHelper;
        $this->scopeConfig = $context->getScopeConfig();
        $this->urlInterface = $context->getUrlBuilder();
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context, $arrayUtils, $data);
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

    /**
     * Return the current page URL
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->urlInterface->getCurrentUrl();
    }

    /**
     * Return the SKU for the current product
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
     * Return the SKU for the current product
     *
     * @return string
     */
    public function getName()
    {
        if ($product = $this->getProduct()) {
            return $product->getName();
        } else {
            return '';
        }
    }

    /**
     * Return the SKU for the current product
     *
     * @return string
     */
    public function getId()
    {
        if ($product = $this->getProduct()) {
            return $product->getId();
        } else {
            return '';
        }
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
