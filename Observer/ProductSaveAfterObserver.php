<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class ProductSaveAfterObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * ProductSaveAfterObserver constructor
     * 
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    /**
     * Pull the product data from the event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            $this->logger->debug("Created/Updated Product ID: " . $product->getId());
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
