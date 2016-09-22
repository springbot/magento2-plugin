<?php

namespace Springbot\Main\Model\ResourceModel\SpringbotTrackable;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define Model and ResourceModel
     */
    protected function _construct()
    {
        $this->_init(
            'Springbot\Main\Model\SpringbotTrackable',
            'Springbot\Main\Model\ResourceModel\SpringbotTrackable'
        );
    }
}
