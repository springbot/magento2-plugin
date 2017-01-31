<?php

namespace Springbot\Main\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\SalesRule\Model\Rule as MagentoRule;
use Magento\Store\Model\Website;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Model\Queue;
use Springbot\Main\Model\Handler\RuleHandler;
use Exception;

/**
 * Class RuleDeleteAfterObserver
 *
 * @package Springbot\Main\Observer
 */
class RuleDeleteAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;
    private $website;

    /**
     * RuleSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue           $queue
     * @param Website         $website
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue, Website $website)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
        $this->website = $website;
    }

    /**
     * Pull the rule data from the event
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $rule = $observer->getEvent()->getRule();
            /* @var MagentoRule $rule */
            foreach ($rule->getWebsiteIds() as $websiteId) {
                $website = $this->website->load($websiteId);
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
