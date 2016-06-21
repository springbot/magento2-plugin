<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Customer as MagentoCustomer;
use Springbot\Main\Model\Handler\CustomerHandler;

class CustomerDeleteAfterObserver implements ObserverInterface
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
     * Pull the customer data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            /* @var MagentoCustomer $customer */
            $this->_queue->scheduleJob(CustomerHandler::class,
                'handleDelete',
                [$customer->getStoreId(), $customer->getId()]);
            $this->_logger->debug("Deleted Customer ID: " . $customer->getId());
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
