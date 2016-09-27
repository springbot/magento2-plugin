<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ObjectManager;
use Magento\Sales\Model\Order;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class EnhancedPixel extends Template
{

    private $order;

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
            $orderFactory = ObjectManager::getInstance()->get('Magento\Sales\Model\OrderFactory');
            $this->order = $orderFactory->create()->load($this->getOrderId());
        }
        return $this->order;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        $session = ObjectManager::getInstance()->get('Magento\Checkout\Model\Session');
        $lastOrder = $session->getLastRealOrder();
        /* @var Order $lastOrder */
        return $lastOrder->getId();
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        $api = ObjectManager::getInstance()->get('Springbot\Main\Model\Api');
        return $api->getApiUrl();
    }

    /**
     * @return string
     */
    public function getStoreGuid()
    {
        $storeConfig = ObjectManager::getInstance()->get('Springbot\Main\Model\StoreConfiguration');
        return strtolower($storeConfig->getGuid($this->getLastOrder()->getStoreId()));
    }
}
