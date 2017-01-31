<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package Springbot\Main\Api
 */
interface CategoryRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\CategoryInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $categoryId
     * @return \Springbot\Main\Api\Entity\Data\CategoryInterface
     */
    public function getFromId($storeId, $categoryId);
}
