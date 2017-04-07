<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Model\Handler\CategoryHandler;

class CategoryDeleteBeforeObserver implements ObserverInterface
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
                $this->queue->scheduleJob(CategoryHandler::class, 'handleDelete', [$storeId, $category->getId()]);
                $this->logger->debug("Deleted Category ID: " . $category->getEntityId());
            }
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
