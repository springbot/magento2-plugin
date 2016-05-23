<?php

namespace Springbot\Main\Api\Data;

/**
 * Interface ModuleInterface
 * 
 * @package Springbot\Main\Api\Data
 */
interface ModuleInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @return boolean
     */
    public function isEnabled();
}