<?php

namespace Springbot\Main\Api;

/**
 * Interface ModulesInterface
 *
 * @package Springbot\Main\Api
 */
interface ModulesInterface
{
    /**
     * Returns a list of all modules with setup version number
     *
     * @return string[]
     */
    public function getModules();
    /**
     * Returns a list of all modules with setup version number
     *
     * @return string[]
     */
    public function getVersion();
}
