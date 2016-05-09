<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Model\Handler\Category as CategoryHandler;

class CategorySaveAfterObserver implements ObserverInterface
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
     * Pull the category data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $category = $observer->getEvent()->getCategory();
            /* @var MagentoCategory $category */
            foreach ($category->getStoreIds() as $storeId) {
                $this->_queue->scheduleJob(CategoryHandler::class, 'handle', [$storeId, $category->getId()]);
                $this->_logger->debug("Created/Updated Category ID: " . $category->getEntityId());
            }
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
