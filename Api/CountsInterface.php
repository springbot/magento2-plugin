<?php

namespace Springbot\Main\Api;

/**
 * Interface CountsInterface
 *
 * @package Springbot\Main\Api
 */
interface CountsInterface
{

    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\CountInterface[]
     */
    public function getCounts($storeId);
}
