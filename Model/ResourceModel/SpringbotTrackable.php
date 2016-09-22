<?php

namespace Springbot\Main\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class SpringbotTrackable
 *
 * @package Springbot\Main\Model\ResourceModel
 */
class SpringbotTrackable extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('springbot_trackable', 'id');
    }
}
