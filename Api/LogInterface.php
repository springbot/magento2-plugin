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
    public function retrieve($filename = "system.log");
    /**
     * @param string $filename
     * @return string|null
     */
    public function lineCount($filename = "system.log");
    /**
     * @param string $filename
     * @return string|null
     */
    public function fileSize($filename = "system.log");
}
