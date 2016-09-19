<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
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
        $rule = $this->objectManager->get('Springbot\Main\Api\Entity\Data\RuleInterface')->load($ruleId);
        /* @var \Springbot\Main\Model\Entity\Data\Rule $rule */
        $data = $rule->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
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
