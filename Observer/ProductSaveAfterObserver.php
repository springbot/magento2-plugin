<?php

namespace Springbot\Main\Observer;

use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Handler\InventoryHandler;
use Springbot\Main\Model\Handler\ProductHandler;
use Magento\Catalog\Model\Product as MagentoProduct;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Exception;
use Magento\Framework\App\ObjectManager;

class ProductSaveAfterObserver implements ObserverInterface
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
     * Pull the product data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            /* @var MagentoProduct $product */
            foreach ($product->getStoreIds() as $storeId) {

                // Enqueue a job to sync this product for every store it belongs to
                $this->_queue->scheduleJob(ProductHandler::class, 'handle', [$storeId, $product->getId()]);

                // Enqueue the stock item as well
                $stockRegistry = ObjectManager::getInstance()->get('Magento\CatalogInventory\Api\StockRegistryInterface');
                $stockItem = $stockRegistry->getStockItem(
                    $product->getId(),
                    $product->getStore()->getWebsiteId()
                );
                $this->_queue->scheduleJob(InventoryHandler::class, 'handle', [$storeId, $stockItem->getId()]);


                $this->_logger->debug("Scheduled sync job for product ID: {$product->getId()}, Store ID: {$storeId}");
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
