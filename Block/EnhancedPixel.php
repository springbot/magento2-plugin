<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Checkout\Model\Session;
use Springbot\Main\Model\Api;
use Springbot\Main\Model\StoreConfiguration;

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

    /**
     * EnhancedPixel constructor.
     * @param OrderFactory $orderFactory
     * @param Api $api
     * @param Session $session
     * @param StoreConfiguration $storeConfig
     */
    public function __construct(OrderFactory $orderFactory, Api $api, Session $session, StoreConfiguration $storeConfig)
    {
        $this->orderFactory = $orderFactory;
        $this->api = $api;
        $this->session = $session;
        $this->storeConfig = $storeConfig;
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
     * @return Order
     */
    public function getLastOrder()
    {
        if (!isset($this->order)) {
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
     * @return string
     */
    public function getStoreGuid()
    {
        return strtolower($this->storeConfig->getGuid($this->getLastOrder()->getStoreId()));
    }
}
