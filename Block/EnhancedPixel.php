<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Checkout\Model\Session;
use Springbot\Main\Model\Api;
use Springbot\Main\Model\StoreConfiguration;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class EnhancedPixel extends Template
{

    private $order;
    private $orderFactory;
    private $api;
    private $session;
    private $storeConfig;

    protected $springbotHelper;
    protected $storeManager;

    /**
     * EnhancedPixel constructor.
     *
     * @param Context            $context
     * @param OrderFactory       $orderFactory
     * @param Api                $api
     * @param Session            $session
     * @param StoreConfiguration $storeConfig
     * @param SpringbotHelper    $springbotHelper
     */
    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        Api $api,
        Session $session,
        StoreConfiguration $storeConfig,
        SpringbotHelper $springbotHelper
    ) {

        $this->orderFactory = $orderFactory;
        $this->api = $api;
        $this->session = $session;
        $this->storeConfig = $storeConfig;
        $this->springbotHelper = $springbotHelper;
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context);
    }


    /**
     * @return float
     */
    public function getConversionValueInDollars()
    {
        $order = $this->getLastOrder();
        return $order->getGrandTotal();
    }

    /**
     * @return string
     */
    public function getIncrementId()
    {
        return $this->getLastOrder()->getIncrementId();
    }

    /**
     * @return string
     */
    public function getIp()
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            return $_SERVER['HTTP_USER_AGENT'];
        } else {
            return "";
        }
    }

    /**
     * @return Order
     */
    public function getLastOrder()
    {
        if (! isset($this->order)) {
            $this->order = $this->orderFactory->create()->load($this->getOrderId());
        }
        return $this->order;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        $lastOrder = $this->session->getLastRealOrder();
        /* @var Order $lastOrder */
        return $lastOrder->getId();
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api->getApiUrl();
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

    /**
     * Return the current URL for the store
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return urlencode($this->storeManager->getStore()->getCurrentUrl());
    }
}
