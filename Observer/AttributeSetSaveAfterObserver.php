<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Springbot\Main\Model\Handler\AttributeSetHandler;
use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;

class AttributeSetSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * @param LoggerInterface $loggerInterface
     * @param Queue           $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
    }

    /**
     * Pull the attribute data from the event
     *
     * @param  Observer $observer
     * @return void
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        try {
            if ($attributeSet = $observer->getEvent()->getObject()) {
                /* @var MagentoAttributeSet $attributeSet */
                $this->queue->scheduleJob(AttributeSetHandler::class, 'handle', [1, $attributeSet->getId()]);
                $this->logger->debug("Created/Updated Attribute ID: " . $attributeSet->getId());
            } else {
                throw new \Exception("Unable to get attribute_set from event observer");
            }
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
