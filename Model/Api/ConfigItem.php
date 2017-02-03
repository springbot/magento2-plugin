<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\ConfigItemInterface;

/**
 * Class Config
 *
 * @package Springbot\Main\Api
 */
class ConfigItem extends AbstractModel implements ConfigItemInterface
{

    protected $path;
    protected $value;

    public function __construct($path, $value)
    {
        $this->path = $path;
        $this->value = $value;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getValue()
    {
        return $this->value;
    }
}
