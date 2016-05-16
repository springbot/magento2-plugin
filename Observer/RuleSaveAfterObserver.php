<?php

namespace Springbot\Main\Observer;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Queue\Model\Queue;
use Springbot\Main\Model\Handler\Rule as RuleHandler;
// use Magento\CatalogInventory\Model\Stock as MagentoInventoryStock; // @Todo figure out model(s) for Rules

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
            $ruleIds = $observer->getEvent()->getAppliedRuleIds();
            /* @var MagentoRule $rule */
            foreach($ruleIds as $ruleId) {
                $this->_queue->scheduleJob(RuleHandler::class, 'handle', [$ruleId]);
                $this->_logger->debug("Scheduled sync job for rule ID: {$ruleId}");
            }
        } catch (Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
