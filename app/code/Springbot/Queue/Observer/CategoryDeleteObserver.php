<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class CategoryDeleteObserver
 * @package Springbot\Queue\Observer
 */
class CategoryDeleteObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $_logger;

    /**
     * @var SpringbotHelper
     */
    private $_springbotHelper;

    /**
     * HarvestProductObserver constructor.
     *
     * @param LoggerInterface $loggerInterface
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        SpringbotHelper $springbotHelper
    ) {
        $this->_logger = $loggerInterface;
        $this->_springbotHelper = $springbotHelper;
    }

    /**
     * Queue up product changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the product from the event
         */
        $category = $observer->getEvent()->getCategory();

        /**
         * Get the store Id
         */
        $storeId = $category->getStoreId();

        /**
         * Grab the product Id
         */
        $categoryId = $category->getId();

        /**
         * Schedule the job
         */
        $this->_springbotHelper->scheduleJob('deleteCategory', [$storeId, $categoryId],
            'Springbot\Main\Helper\QueueCategoryChanges', 'listener', 5);
    }
}
