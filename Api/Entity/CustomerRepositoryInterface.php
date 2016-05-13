<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CustomerRepositoryInterface
 * @package Springbot\Main\Api
 */
interface CustomerRepositoryInterface
{
    /**
     * Get store configuration
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\Data\CustomerInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $customerId
     * @return \Springbot\Main\Api\Data\CustomerInterface
     */
    public function getFromId($storeId, $customerId);

}
