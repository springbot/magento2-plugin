<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Psr\Log\LoggerInterface;
use Springbot\Main\Model\SpringbotOrderRedirect;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler\OrderHandler;

class OrderSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $orderRedirect;
    private $cookieManager;

    /**
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     * @param SpringbotOrderRedirect $orderRedirect
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        SpringbotOrderRedirect $orderRedirect,
        CookieManagerInterface $cookieManager
    )
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->orderRedirect = $orderRedirect;
        $this->cookieManager = $cookieManager;
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
            $orderId = $order->getId();

            if ($redirects = $this->cookieManager->getCookie('springbot_redirect_queue')) {
                foreach (explode('|', $redirects) as $redirect) {
                    $this->orderRedirect->insert($orderId, $redirect);
                }
            }
            $this->queue->scheduleJob(OrderHandler::class, 'handle', [$order->getStoreId(), $orderId]);
            $this->logger->debug("Scheduled sync job for product ID: {$orderId}, Store ID: {$order->getStoreId()}");
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
