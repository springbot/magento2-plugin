<?php

namespace Springbot\Main\Observer;

use Exception;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Main\Model\Handler\CartHandler;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote as MagentoQuote;
use Psr\Log\LoggerInterface;


class QuoteDeleteAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * QuoteDeleteAfterObserver constructor
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
     * Pull the quote data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $quote = $observer->getEvent()->getQuote();
            /* @var MagentoQuote $quote */
            $this->_queue->scheduleJob(CartHandler::class, 'handleDelete', [$quote->getId()]);
            $this->_logger->debug("Scheduled deleted sync job for quote ID: {$quote->getId()}");
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
