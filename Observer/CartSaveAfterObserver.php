<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote as MagentoQuote;
use Springbot\Main\Model\Handler\CartHandler;

class CartSaveAfterObserver implements ObserverInterface
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
     * Pull the cart data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $cart = $observer->getEvent()->getQuote();
            /* @var MagentoQuote $cart */
            $cartId = $cart->getEntityId();
            $this->_queue->scheduleJob(CartHandler::class, 'handle', [$cart->getStoreId(), $cartId]);
            $this->_logger->debug("Created/Updated Cart ID: {$cartId}");
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
