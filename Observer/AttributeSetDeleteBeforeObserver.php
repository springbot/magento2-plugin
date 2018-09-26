<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Entity\Attribute as MagentoAttribute;
use Springbot\Main\Model\Handler\AttributeSetHandler;
use Magento\Store\Model\StoreManagerInterface;

class AttributeSetDeleteBeforeObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $storeManager;

    /**
     * AttributeSetDeleteBeforeObserver constructor.
     *
     * @param LoggerInterface       $loggerInterface
     * @param Queue                 $queue
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        StoreManagerInterface $storeManager
    ) {

        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->storeManager = $storeManager;
    }

    /**
     * Pull the attribute data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $attributeSet = $observer->getEvent()->getObject();
            /* @var MagentoAttribute $attribute */
            foreach ($this->storeManager->getStores() as $store) {
                $this->queue->scheduleJob(
                    AttributeSetHandler::class,
                    'handleDelete',
                    [$store->getId(), $attributeSet->getAttributeSetId()]
                );
            }
            $this->logger->debug("Deleted attribute set: " . $attributeSet->getId());
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
