<?php

namespace Springbot\Main\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class LogFormat
 *
 * @package Springbot\Main\Model\Config\Source
 */
class LogFormat implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default')],
            ['value' => 'simple', 'label' => __('Simple')],
            ['value' => 'expanded', 'label' => __('Expanded')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['default' => __('Default'), 'simple' => __('Simple'), 'expanded' => __('Expanded')];
    }
}
