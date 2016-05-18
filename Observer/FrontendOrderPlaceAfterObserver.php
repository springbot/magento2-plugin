<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler\OrderHandler;
use Magento\Checkout\Model\Session;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Springbot\Main\Model\SpringbotOrderRedirect;

class FrontendOrderPlaceAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;
    private $_cookieManager;
    private $_orderRedirectFactory;

    /**
     * ProductSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     * @param CookieManagerInterface $cookieManager
     * @param SpringbotOrderRedirect $orderRedirect
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        CookieManagerInterface $cookieManager,
        SpringbotOrderRedirect $orderRedirect
    ) {
        $this->_logger = $loggerInterface;
        $this->_queue = $queue;
        $this->_cookieManager = $cookieManager;
        $this->_orderRedirect = $orderRedirect;
    }

    /**
     * Pull the order data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            /* @var MagentoOrder $order */
            $orderId = $order->getEntityId();
            $this->_setRedirectIdsFromCookie($orderId);
            $this->_logger->debug("Scheduled sync job for product ID: {$orderId}, Store ID: {$order->getStoreId()}");
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }

    /**
     * @param $orderId
     */
    private function _setRedirectIdsFromCookie($orderId)
    {
        $redirectIdsStr = $this->_cookieManager->getCookie('springbot_redirect_queue');
        $redirectIdsArr = explode('|', $redirectIdsStr);
        foreach ($redirectIdsArr as $redirectId) {
            $this->_orderRedirect->insert($orderId, $redirectId);
        }
    }

}
