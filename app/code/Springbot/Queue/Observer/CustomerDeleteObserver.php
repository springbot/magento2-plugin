<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class CustomerDeleteObserver
 * @package Springbot\Queue\Observer
 */
class CustomerDeleteObserver implements ObserverInterface
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
     * CustomerDeleteObserver constructor.
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
     * Queue up customer changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the customer from the event
         */
        $customer = $observer->getEvent()->getCustomer();

        /**
         * Get the store Id
         */
        $storeId = $customer->getStoreId();

        /**
         * Grab the Customer Id
         */
        $customerId = $customer->getId();

        /**
         * Schedule the job
         */
        $this->_springbotHelper->scheduleJob('deleteCustomer', [$storeId, $customerId],
            'Springbot\Main\Helper\QueueCustomerChanges', 'listener', 5);
    }
}
