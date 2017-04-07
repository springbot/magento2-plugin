<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface RuleRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface RuleRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\RuleInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $ruleId
     * @return \Springbot\Main\Api\Entity\Data\RuleInterface
     */
    public function getFromId($storeId, $ruleId);
}
