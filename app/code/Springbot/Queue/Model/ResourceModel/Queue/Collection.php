<?php

namespace Springbot\Queue\Model\ResourceModel\Queue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define Model and ResourceModel
     */
    protected function _construct()
    {
        $this->_init(
            'Springbot\Queue\Model\Queue',
            'Springbot\Queue\Model\ResourceModel\Queue'
        );
    }
}
