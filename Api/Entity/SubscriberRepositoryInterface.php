<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface SubscriberRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface SubscriberRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\SubscriberInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $subscriberId
     * @return \Springbot\Main\Api\Entity\Data\SubscriberInterface
     */
    public function getFromId($storeId, $subscriberId);
}
