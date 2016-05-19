<?php

namespace Springbot\Main\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\Stock as MagentoInventoryStock;
use Springbot\Main\Model\Handler\Inventory as InventoryHandler;
use Springbot\Queue\Model\Queue;
use Exception;

class InventorySaveAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * InventorySaveAfterObserver constructor
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
     * Pull the inventory data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $items = $observer->getEvent()->getItems();
            /* @var MagentoItem $item */
            foreach($items as $item) {
                $this->_queue->scheduleJob(InventoryHandler::class, 'handle', [$item->getItemId()]);
                $this->_logger->debug("Scheduled sync job for item ID: {$item->getItemId()}");
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
