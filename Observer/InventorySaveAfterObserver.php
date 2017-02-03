<?php

namespace Springbot\Main\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\Stock as MagentoInventoryStock;
use Springbot\Main\Model\Handler\InventoryHandler;
use Springbot\Queue\Model\Queue;
use Exception;

class InventorySaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * InventorySaveAfterObserver constructor
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
            if (is_array($items)) {
                foreach ($items as $item) {
                    $this->queue->scheduleJob(InventoryHandler::class, 'handle', [$item->getItemId()]);
                    $this->logger->debug("Scheduled sync job for item ID: {$item->getItemId()}");
                }
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
