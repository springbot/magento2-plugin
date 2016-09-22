<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Product\AttributeSet;
use Magento\Catalog\Model\Entity\Attribute as MagentoAttribute;
use Springbot\Main\Model\Handler\AttributeSetHandler;

class AttributeSetDeleteBeforeObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;
    private $_storeManager;

    /**
     * ProductSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_logger = $loggerInterface;
        $this->_queue = $queue;
        $this->_storeManager = $storeManager;
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
            $attributeSet = $observer->getEvent()->getObject();
            /* @var MagentoAttribute $attribute */

            foreach ($this->_storeManager->getStores() as $store) {
                $this->_queue->scheduleJob(AttributeSetHandler::class,
                    'handleDelete',
                    [$store->getId(), $attributeSet->getAttributeSetId()]);
            }

            $this->_logger->debug("Deleted attribute set: " . $attributeSet->getId());
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
