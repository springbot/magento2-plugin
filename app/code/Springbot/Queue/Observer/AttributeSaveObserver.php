<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class AttributeSaveObserver
 * @package Springbot\Queue\Observer
 */
class AttributeSaveObserver implements ObserverInterface
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
     * AttributeSaveObserver constructor.
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
     * Queue up attribute changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the attribute from the event
         */
        $attribute = $observer->getEvent()->getAttribute();

        /**
         * Get the store Id
         */
        $storeId = $attribute->getStoreId();

        /**
         * Grab the Attribute Id
         */
        $attributeId = $attribute->getId();

        /**
         * Schedule the job
         */
        $this->_springbotHelper->scheduleJob('addAttribute', [$storeId, $attributeId],
            'Springbot\Main\Helper\QueueAttributeChanges', 'listener', 5);
    }
}
