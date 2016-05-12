<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\SalesRule\Model\Rule as MagentoRule;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Rule extends Handler
{
    const API_PATH = 'promotions';
    const ENTITIES_NAME = 'promotions';

    /**
     * @param $storeId
     * @param $ruleId
     * @throws \Exception
     */
    public function handle($storeId, $ruleId)
    {
        $rule = $this->objectManager->get('Magento\SalesRule\Model\Rule');
        /* @var MagentoRule $rule */
        $rule->load($ruleId);
        $array = $rule->toArray();
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    /**
     * @param $storeId
     * @param $ruleId
     */
    public function handleDelete($storeId, $ruleId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $ruleId]);
    }
}
