<?php

namespace Springbot\Main\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class ProductUrlType
 *
 * @package Springbot\Main\Model\Config\Source
 */
class ProductUrlType implements ArrayInterface
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
            ['value' => 'id_path', 'label' => __('Id Path')],
            ['value' => 'in_store', 'label' => __('In Store')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['default' => __('Default'), 'id_path' => __('Id Path'), 'in_store' => __('In Store')];
    }
}
