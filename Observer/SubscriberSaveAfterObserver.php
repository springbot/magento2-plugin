<?php

namespace Springbot\Main\Observer;

use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Handler\SubscriberHandler;
use Magento\Newsletter\Model\Subscriber as MagentoSubscriber;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Exception;

class SubscriberSaveAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * SubscriberSaveAfterObserver constructor
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
     * Pull the subscriber data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $subscriber = $observer->getEvent()->getSubscriber();
            /* @var MagentoSubscriber $subscriber */
            $this->_queue->scheduleJob(SubscriberHandler::class,
                'handle',
                [$subscriber->getStoreId(), $subscriber->getId()]);
            $this->_logger->debug("Scheduled sync job for subscriber ID: {$subscriber->getId()}, Store ID: {$subscriber->getStoreId()}");
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
