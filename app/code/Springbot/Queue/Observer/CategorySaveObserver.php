<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class CategorySaveObserver
 * @package Springbot\Queue\Observer
 */
class CategorySaveObserver implements ObserverInterface
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
     * CategorySaveObserver constructor.
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
     * Queue up category changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the category from the event
         */
        $category = $observer->getEvent()->getCategory();

        /**
         * Get the store Id
         */
        $storeId = $category->getStoreId();

        /**
         * Grab the category Id
         */
        $categoryId = $category->getId();

        /**
         * Schedule the job
         */
        $this->_springbotHelper->scheduleJob('updateCategory', [$storeId, $categoryId],
            'Springbot\Main\Helper\QueueCategoryChanges', 'listener', 5);
    }
}
