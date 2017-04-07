<?php

namespace Springbot\Main\Api;

/**
 * Interface ConfigItemInterface
 *
 * @package Springbot\Main\Api
 */
interface ConfigItemInterface
{
    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getValue();
}
