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
use Magento\CatalogInventory\Model\StockRegistryFactory;

class ProductSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $stockFactory;

    /**
     * ProductSaveAfterObserver constructor
     *
     * @param LoggerInterface      $loggerInterface
     * @param Queue                $queue
     * @param StockRegistryFactory $stockFactory
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue, StockRegistryFactory $stockFactory)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->stockFactory = $stockFactory;
    }

    /**
     * Pull the product data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            /* @var MagentoProduct $product */
            foreach ($product->getStoreIds() as $storeId) {
                // Enqueue a job to sync this product for every store it belongs to
                $this->queue->scheduleJob(ProductHandler::class, 'handle', [$storeId, $product->getId()]);

                // Enqueue the stock item as well
                $stockRegistry = $this->stockFactory->create();
                $stockItem = $stockRegistry->getStockItem(
                    $product->getId(),
                    $product->getStore()->getWebsiteId()
                );
                $this->queue->scheduleJob(InventoryHandler::class, 'handle', [$storeId, $stockItem->getId()]);
                $this->logger->debug("Scheduled sync job for product ID: {$product->getId()}, Store ID: {$storeId}");
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
