<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CustomerRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface CustomerRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\CustomerInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $customerId
     * @return \Springbot\Main\Api\Entity\Data\CustomerInterface
     */
    public function getFromId($storeId, $customerId);
}
