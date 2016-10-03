<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote as MagentoQuote;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Handler\CartHandler;
use Springbot\Main\Model\SpringbotQuoteRedirect;
use Springbot\Queue\Model\Queue;

class CartSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $quoteRedirect;
    private $session;

    /**
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     * @param SpringbotQuoteRedirect $quoteRedirect
     * @param CookieManagerInterface $session
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        SpringbotQuoteRedirect $quoteRedirect,
        CookieManagerInterface $session
    )
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->quoteRedirect = $quoteRedirect;
        $this->session = $session;
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
            $this->queue->scheduleJob(CartHandler::class, 'handle', [$cart->getStoreId(), $cartId]);
            $this->logger->debug("Created/Updated Cart ID: {$cartId}");
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
