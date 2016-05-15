<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface OrderRepositoryInterface
 * @package Springbot\Main\Api
 */
interface OrderRepositoryInterface
{
    /**
     * Get store configuration
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $orderId
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface
     */
    public function getFromId($storeId, $orderId);
}
