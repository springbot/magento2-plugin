<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class SubscriberSaveObserver
 * @package Springbot\Queue\Observer
 */
class SubscriberSaveObserver implements ObserverInterface
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
     * SubscriberSaveObserver constructor.
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
     * Queue up subscriber changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the subscriber from the event
         */
        $subscriber = $observer->getEvent()->getAttribute();

        /**
         * Get the store Id
         */
        $storeId = $subscriber->getStoreId();

        /**
         * Grab the subscriber Id
         */
        $subscriberId = $subscriber->getId();

        /**
         * Schedule the job
         */
        $this->_springbotHelper->scheduleJob('addSubscriber', [$storeId, $subscriberId],
            'Springbot\Main\Helper\QueueSubscriberChanges', 'listener', 5);
    }
}
