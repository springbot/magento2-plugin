<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Framework\App\Request\Http;
use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Handler\CustomerHandler;
use Springbot\Main\Model\Handler\OrderHandler;
use Springbot\Main\Model\Handler\GuestHandler;
use Springbot\Main\Model\SpringbotOrderRedirect;
use Springbot\Queue\Model\Queue;

class OrderSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $orderRedirect;
    private $cookieManager;
    private $springbotTrackable;
    private $request;

    /**
     * @param LoggerInterface        $loggerInterface
     * @param Queue                  $queue
     * @param SpringbotOrderRedirect $orderRedirect
     * @param CookieManagerInterface $cookieManager
     * @param Http                   $request
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        SpringbotOrderRedirect $orderRedirect,
        CookieManagerInterface $cookieManager,
        Http $request
    ) {

        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->orderRedirect = $orderRedirect;
        $this->cookieManager = $cookieManager;
        $this->request = $request;
    }

    /**
     * Pull the order data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            /* @var MagentoOrder $order */
            $orderId = $order->getId();
            if ($redirects = $this->cookieManager->getCookie('springbot_redirect_queue')) {
                foreach (explode('|', $redirects) as $redirect) {
                    $this->orderRedirect->insert($orderId, $redirect);
                }
            }
            $this->queue->scheduleJob(OrderHandler::class, 'handle', [$order->getStoreId(), $orderId]);
            if ($order->getCustomerIsGuest()) {
                $this->queue->scheduleJob(GuestHandler::class, 'handle', [$order->getStoreId(), $orderId]);
            } else {
                $this->queue->scheduleJob(CustomerHandler::class, 'handle', [$order->getStoreId(), $order->getCustomerId()]);
            }
            $this->logger->debug("Scheduled sync job for order ID: {$orderId}, Store ID: {$order->getStoreId()}");
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
