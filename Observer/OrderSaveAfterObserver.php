<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler\OrderHandler;

class OrderSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * ProductSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue
    ) {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
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
            $this->queue->scheduleJob(OrderHandler::class, 'handle', [$order->getStoreId(), $orderId]);
            $this->logger->debug("Scheduled sync job for product ID: {$orderId}, Store ID: {$order->getStoreId()}");
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
