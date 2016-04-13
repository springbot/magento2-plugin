<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CustomerSaveAfterObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * CustomerSaveAfterObserver constructor.
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    /**
     * Pull the customer data from the event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            $this->logger->debug("Created/Updated Customer ID: " . $customer->getId());
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
