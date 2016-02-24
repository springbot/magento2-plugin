<?php

namespace Springbot\Queue\Model;

use Magento\Framework\Model\AbstractModel;

class Queue extends AbstractModel
{
    /**
     * Define ResourceModel
     */
    protected function _construct()
    {
        $this->_init('Springbot\Queue\Model\ResourceModel\Queue');
    }
}
