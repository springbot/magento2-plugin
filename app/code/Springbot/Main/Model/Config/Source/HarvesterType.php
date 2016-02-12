<?php

namespace Springbot\Main\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class HarvesterType
 *
 * @package Springbot\Main\Model\Config\Source
 */
class HarvesterType implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'prattler', 'label' => __('Prattler')], ['value' => 'cron', 'label' => __('Cron')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['prattler' => __('Prattler'), 'cron' => __('Cron')];
    }
}
