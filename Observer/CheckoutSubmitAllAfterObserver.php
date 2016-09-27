<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Checkout\Model\Session;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Springbot\Main\Model\SpringbotOrderRedirect;

class CheckoutSubmitAllAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $cookieManager;

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
        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->cookieManager = $cookieManager;
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
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * @param $orderId
     */
    private function _setRedirectIdsFromCookie($orderId)
    {
        $redirectIdsStr = $this->cookieManager->getCookie('springbot_redirectqueue');
        $redirectIdsArr = explode('|', $redirectIdsStr);
        foreach ($redirectIdsArr as $redirectId) {
            $this->_orderRedirect->insert($orderId, $redirectId);
        }
    }
}
