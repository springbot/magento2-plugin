<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class AdminPurchaseSaveAfterObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * AdminPurchaseSaveAfterObserver constructor.
     *
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    /**
     * Pull the purchase data from the event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $purchase = $observer->getEvent()->getOrder();
            $this->logger->debug(
                "Quote ID: " . $purchase->getQuoteId() . "\n" .
                "Customer ID: " . $purchase->getCustomerId() . "\n" .
                "Customer Email: " . $purchase->getCustomerEmail() . "\n" .
                "Entity ID: " . $purchase->getEntityId()
            );
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
