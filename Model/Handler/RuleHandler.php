<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class RuleHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class RuleHandler extends AbstractHandler
{
    const api_path = 'rules';

    /**
     * @param $storeId
     * @param $ruleId
     * @throws \Exception
     */
    public function handle($storeId, $ruleId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $ruleId]);
    }

    /**
     * @param $storeId
     * @param $ruleId
     */
    public function handleDelete($storeId, $ruleId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $ruleId]);
    }
}
