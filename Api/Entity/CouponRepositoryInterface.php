<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CouponRepositoryInterface
 * @package Springbot\Main\Api
 */
interface CouponRepositoryInterface
{
    /**
     * Get store configuration
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\Data\CouponInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $couponId
     * @return \Springbot\Main\Api\Data\CouponInterface
     */
    public function getFromId($storeId, $couponId);

}
