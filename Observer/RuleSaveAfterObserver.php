<?php

namespace Springbot\Main\Observer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Magento\Framework\Event\Observer;
use Springbot\Main\Model\Handler\RuleHandler;
use Magento\SalesRule\Model\Rule as MagentoRule;
use Magento\Store\Model\Website as MagentoWebsite;
use Exception;

/**
 * Class RuleSaveAfterObserver
 * @package Springbot\Main\Observer
 */
class RuleSaveAfterObserver implements ObserverInterface
{
    private $_logger;
    private $_queue;

    /**
     * RuleSaveAfterObserver constructor
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
     * Pull the rule data from the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $rule = $observer->getEvent()->getRule();
            /* @var MagentoRule $rule */
            foreach ($rule->getWebsiteIds() as $websiteId) {
                $website = ObjectManager::getInstance()->get('Magento\Store\Model\Website')->load($websiteId);
                /* @var MagentoWebsite $website */
                foreach ($website->getStoreIds() as $storeId) {
                    $this->_queue->scheduleJob(RuleHandler::class, 'handle', [$storeId, $rule->getId()], 1);
                    $this->_logger->debug("Scheduled sync job for Rule ID: {$rule->getId()} in store id: {$storeId}");
                }
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
