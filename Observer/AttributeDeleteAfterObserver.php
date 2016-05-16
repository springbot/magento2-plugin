<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Product\AttributeSet;
use Magento\Catalog\Model\Entity\Attribute as MagentoAttribute;
use Springbot\Main\Model\Handler\AttributeSetHandler;

class AttributeDeleteAfterObserver implements ObserverInterface
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
     * Pull the attribute data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $attribute = $observer->getEvent()->getAttribute();
            /* @var MagentoAttribute $attribute */
            $this->_queue->scheduleJob(AttributeSetHandler::class, 'handle', [1, $attribute->getAttributeSetId()]);  // TODO: Figure out how to determine store_id
            $this->_logger->debug("Created/Updated Attribute ID: " . $attribute->getAttributeId());
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
