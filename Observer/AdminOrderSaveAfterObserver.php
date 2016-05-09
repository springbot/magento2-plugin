<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler\Order as OrderHandler;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;

class AdminOrderSaveAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * ProductSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->_logger = $loggerInterface;
        $this->_queue = $queue;
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
            $this->_queue->scheduleJob(OrderHandler::class, 'handle', [$order->getStoreId(), $order->getId()]);
            $this->_logger->debug("Scheduled sync job for product ID: {$order->getId()}, Store ID: {$order->getStoreId()}");
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
