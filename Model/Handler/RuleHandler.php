<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\SalesRule\Model\Rule as MagentoRule;

/**
 * Class RuleHandler
 * @package Springbot\Main\Model\Handler
 */
class RuleHandler extends Handler
{
    const API_PATH = 'rules';

    /**
     * @param $storeId
     * @param $ruleId
     * @throws \Exception
     */
    public function handle($storeId, $ruleId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $ruleId]);
    }

    /**
     * @param $storeId
     * @param $ruleId
     */
    public function handleDelete($storeId, $ruleId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $ruleId]);
    }
}
