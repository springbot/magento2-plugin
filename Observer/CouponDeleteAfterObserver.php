<?php

namespace Springbot\Main\Observer;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Springbot\Main\Model\Handler\Coupon as CouponHandler;
// use Magento\CatalogInventory\Model\Stock as MagentoInventoryStock; // @Todo figure out model(s) for Rules

class CouponDeleteAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * CouponDeleteAfterObserver constructor
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
     * Pull the coupon data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $rule = $observer->getEvent()->getRule();
            /* @var MagentoRule $rule */
            $this->_queue->scheduleJob(CouponHandler::class, 'handleDelete', [$rule->getCouponCode(), $rule->getId()]);
            $this->_logger->debug("Scheduled deleted sync job for coupon code: {$rule->getCouponCode()}, rule ID: {$rule->getId}");
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
