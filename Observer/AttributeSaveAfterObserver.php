<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class AttributeSaveAfterObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * AttributeSaveAfterObserver constructor.
     *
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    /**
     * Pull the attribute data from the event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $attribute = $observer->getEvent()->getAttribute();
            $this->logger->debug("Created/Updated Attribute ID: " . $attribute->getAttributeId());
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
