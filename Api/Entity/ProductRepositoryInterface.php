<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface ProductRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface ProductRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\ProductInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $productId
     * @return \Springbot\Main\Api\Entity\Data\ProductInterface
     */
    public function getFromId($storeId, $productId);
}
