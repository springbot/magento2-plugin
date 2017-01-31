<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Model\Handler\CategoryHandler;

class CategorySaveAfterObserver implements ObserverInterface
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
     * Pull the category data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $category = $observer->getEvent()->getCategory();
            /* @var MagentoCategory $category */
            foreach ($category->getStoreIds() as $storeId) {
                if ($storeId != 0) {
                    $this->queue->scheduleJob(CategoryHandler::class, 'handle', [$storeId, $category->getId()]);
                    $this->logger->debug("Created/Updated Category ID: " . $category->getEntityId());
                }
            }
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
