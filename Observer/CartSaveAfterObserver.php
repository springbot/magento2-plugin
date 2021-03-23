<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote as MagentoQuote;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\App\Request\Http;
use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Handler\CartHandler;
use Springbot\Queue\Model\Queue;

class CartSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $session;
    private $request;

    /**
     * @param LoggerInterface        $loggerInterface
     * @param Queue                  $queue
     * @param CookieManagerInterface $session
     * @param Http                   $request
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        Queue $queue,
        CookieManagerInterface $session,
        Http $request
    ) {

        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->session = $session;
        $this->request = $request;
    }

    /**
     * Pull the cart data from the event
     *
     * @param  Observer $observer
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
