<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface GuestRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface GuestRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\GuestInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $guestId
     * @return \Springbot\Main\Api\Entity\Data\GuestInterface
     */
    public function getFromId($storeId, $guestId);
}
