<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface SubscriberRepositoryInterface
 * @package Springbot\Main\Api
 */
interface SubscriberRepositoryInterface
{
    /**
     * Get store configuration
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\Data\SubscriberInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $subscriberId
     * @return \Springbot\Main\Api\Data\SubscriberInterface
     */
    public function getFromId($storeId, $subscriberId);

}
