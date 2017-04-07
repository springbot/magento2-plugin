<?php

namespace Springbot\Main\Api;

/**
 * Interface ConfigInterface
 *
 * @package Springbot\Main\Api
 */
interface ConfigInterface
{
    /**
     * Get store configuration
     *
     * @return \Springbot\Main\Api\ConfigItemInterface[]
     */
    public function getConfig();

    /**
     * @param string $path
     * @param string $value
     * @return \Springbot\Main\Api\ConfigInterface
     */
    public function saveConfig($path, $value);
}
