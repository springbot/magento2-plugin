<?php

namespace Springbot\Main\Observer;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Springbot\Main\Model\Handler\RuleHandler;
use Springbot\Queue\Model\Queue;

class SalesRuleSaveAfterObserver implements ObserverInterface
{
    private $logger;
    private $queue;

    /**
     * RuleSaveAfterObserver constructor
     *
     * @param LoggerInterface $loggerInterface
     * @param Queue           $queue
     */
    public function __construct(LoggerInterface $loggerInterface, Queue $queue)
    {
        $this->logger = $loggerInterface;
        $this->queue = $queue;
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
            $ruleIds = $observer->getEvent()->getAppliedRuleIds();
            foreach ($ruleIds as $ruleId) {
                $this->queue->scheduleJob(RuleHandler::class, 'handle', [$ruleId]);
                $this->logger->debug("Scheduled sync job for rule ID: {$ruleId}");
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
