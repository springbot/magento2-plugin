<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
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

    protected $storeManager;
    protected $springbotHelper;

    /**
     * EnhancedPixel constructor.
     * @param Context $context
     * @param OrderFactory $orderFactory
     * @param Api $api
     * @param Session $session
     * @param StoreConfiguration $storeConfig
     * @param SpringbotHelper $springbotHelper
     * @param StoreManager $storeManager
     */
    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        Api $api,
        Session $session,
        StoreConfiguration $storeConfig,
        SpringbotHelper $springbotHelper,
        StoreManager $storeManager
    )
    {
        $this->orderFactory = $orderFactory;
        $this->api = $api;
        $this->session = $session;
        $this->storeConfig = $storeConfig;
        $this->springbotHelper = $springbotHelper;
        $this->storeManager = $storeManager;
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
