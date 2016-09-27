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
 * Class RuleDeleteAfterObserver
 * @package Springbot\Main\Observer
 */
class RuleDeleteAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * RuleSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
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
                    $this->queue->scheduleJob(RuleHandler::class, 'handleDelete', [$storeId, $rule->getId()], 1);
                    $this->logger->debug("Scheduled deleted sync job for Rule ID: {$rule->getId()} in store id: {$storeId}");
                }
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
