<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Magento\SalesRule\Model\Coupon as MagentoCoupon;
use Springbot\Main\Model\Handler\CouponHandler;
use Magento\Framework\App\ObjectManager;
use Magento\SalesRule\Model\Rule as MagentoRule;
use Magento\Store\Model\Website as MagentoWebsite;

/**
 * Class CouponSaveAfterObserver
 * @package Springbot\Main\Observer
 */
class CouponSaveAfterObserver implements ObserverInterface
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
     * Pull the coupon data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $coupon = $observer->getEvent()->getCoupon();
            /* @var MagentoCoupon $coupon */

            $rule = ObjectManager::getInstance()->get('Magento\SalesRule\Model\Rule')->load($coupon->getRuleId());
            /* @var MagentoRule $rule */
            foreach ($rule->getWebsiteIds() as $websiteId) {
                $website = ObjectManager::getInstance()->get('Magento\Store\Model\Website')->load($websiteId);
                /* @var MagentoWebsite $website */
                foreach ($website->getStoreIds() as $storeId) {
                    $this->_queue->scheduleJob(CouponHandler::class, 'handle', [$storeId, $coupon->getCouponId()]);
                    $this->_logger->debug("Created/Updated Coupon ID: " . $coupon->getCouponId());
                }
            }
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
