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
     * @param int $lineCount
     * @return string
     */
    public function retrieve($filename = "system", $lineCount = 100);
    /**
     * @param string $filename
     * @return int|string
     */
    public function lineCount($filename = "system");
    /**
     * @param string $filename
     * @param string $precision
     * @return string
     */
    public function fileSize($filename = "system", $precision = 2);
}
