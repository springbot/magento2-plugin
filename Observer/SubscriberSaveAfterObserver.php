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
    private $logger;
    private $queue;

    /**
     * SubscriberSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue           $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
    }

    /**
     * Pull the subscriber data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $subscriber = $observer->getEvent()->getSubscriber();
            /* @var MagentoSubscriber $subscriber */
            $this->queue->scheduleJob(
                SubscriberHandler::class,
                'handle',
                [$subscriber->getStoreId(), $subscriber->getId()]
            );
            $this->logger->debug("Scheduled sync job for subscriber ID: {$subscriber->getId()}, Store ID: {$subscriber->getStoreId()}");
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
