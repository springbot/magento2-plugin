<?php

namespace Springbot\Main\Api;

/**
 * Interface CountsInterface
 * @package Springbot\Main\Api
 */
interface CountsInterface
{
    /**
     * Returns an array of all the entity counts we care about.
     *
     * @param int $storeId
     * @return array
     */
    public function getCounts($storeId);
}
