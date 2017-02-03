<?php

namespace Springbot\Main\Api;

/**
 * Interface StoresInterface
 *
 * @package Springbot\Main\Api
 */
interface StoresInterface
{

    /**
     * Return a list of all redirects
     *
     * @return \Springbot\Main\Api\StoreInterface[]
     */
    public function getStores();

    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\StoreInterface
     */
    public function getFromId($storeId);
}
