<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CartRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface CartRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\CartInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $cartId
     * @return \Springbot\Main\Api\Entity\Data\CartInterface
     */
    public function getFromId($storeId, $cartId);
}
