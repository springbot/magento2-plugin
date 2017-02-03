<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Springbot\Main\Model\Handler\ProductHandler;
use Magento\Catalog\Model\Product as MagentoProduct;
use Exception;

class ProductDeleteBeforeObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * ProductSaveAfterObserver constructor
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
                $this->queue->scheduleJob(
                    ProductHandler::class,
                    'handleDelete',
                    [$product->getStoreId(), $product->getId()]
                );
                $this->logger->debug("Scheduled deleted sync job for product ID: {$product->getId()}, Store ID: {$storeId}");
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
