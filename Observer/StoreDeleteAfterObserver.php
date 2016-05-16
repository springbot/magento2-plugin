<?php

namespace Springbot\Main\Observer;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Springbot\Main\Model\Handler\Store as StoreHandler;

class StoreDeleteAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * StoreDeleteAfterObserver constructor
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
     * Pull the store data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $stores = $observer->getEvent()->getStores();
            foreach ($stores as $store) {
                $this->_queue->scheduleJob(StoreHandler::class, 'handleDelete', [$store->getId()], 1);
                $this->_logger->debug("Scheduled deleted sync job for Store ID: {$store->getId()}");
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
