<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Springbot\Main\Model\Handler\Store as StoreHandler;
use Magento\Catalog\Model\Product as MagentoProduct;
use Exception;

class StoreDeleteAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * StoreSaveAfterObserver constructor
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

                // Enqueue a job to sync this store
                $this->_queue->scheduleJob(StoreHandler::class, 'handleDelete', [$store->getId()], 1);
                $this->_logger->debug("Scheduled deleted sync job for Store ID: {$store->getId()}");
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
