<?php

namespace Springbot\Main\Api;

/**
 * Interface CacheInterface
 * @package Springbot\Main\Api
 */
interface CacheInterface
{

    /**
     * @param string $cacheType
     * @return string|null
     */
    public function clean($cacheType = null);


    /**
     * @return string[]
     */
    public function getAvailableTypes();


    /**
     * Presents summary about cache status
     *
     * @return string[]
     */
    public function getStatus();
}
