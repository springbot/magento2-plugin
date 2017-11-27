<?php

namespace Springbot\Main\Api;

/**
 * Interface LogInterface
 * @package Springbot\Main\Api
 */
interface LogInterface
{

    /**
     * @param string $filename
     * @return string|null
     */
    public function retrieve($filename="system.log");
}
