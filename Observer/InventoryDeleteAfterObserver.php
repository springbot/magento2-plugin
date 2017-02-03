<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Springbot\Main\Model\Handler\InventoryHandler;
use Magento\CatalogInventory\Model\Stock as MagentoInventoryStock;
use Exception;

class InventoryDeleteAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * InventoryDeleteAfterObserver constructor
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
     * Pull the inventory data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $items = $observer->getEvent()->getItems();
            /* @var MagentoInventoryStock $inventory */
            foreach ($items as $item) {
                $this->queue->scheduleJob(InventoryHandler::class, 'handleDelete', [$item->getItemId()]);
                $this->logger->debug("Scheduled deleted sync job for inventory item ID: {$item->getId()}");
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
