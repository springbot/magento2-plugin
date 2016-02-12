<?php

namespace Springbot\Main\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class LogLevel
 *
 * @package Springbot\Main\Model\Config\Source
 */
class LogLevel implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'info', 'label' => __('Info')], ['value' => 'debug', 'label' => __('Debug')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['info' => __('Info'), 'debug' => __('Debug')];
    }
}
