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
     * @return array
     */
    public function getModules();
}