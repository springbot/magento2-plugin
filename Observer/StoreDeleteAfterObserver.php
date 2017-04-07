<?php

namespace Springbot\Main\Observer;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Springbot\Main\Model\Handler\StoreHandler;

class StoreDeleteAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * RuleSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue           $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
    }

    /**
     * Pull the rule data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $storeId = $observer->getEvent()->getStoreId();
            $this->queue->scheduleJob(StoreHandler::class, 'handle', [$storeId]);
            $this->logger->debug("Scheduled sync job for store ID: {$storeId}");
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
