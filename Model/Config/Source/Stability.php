<?php

namespace Springbot\Main\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Stability
 *
 * @package Springbot\Main\Model\Config\Source
 */
class Stability implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'stable', 'label' => __('Stable')], ['value' => 'beta', 'label' => __('Beta')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['stable' => __('Stable'), 'beta' => __('Beta')];
    }
}
