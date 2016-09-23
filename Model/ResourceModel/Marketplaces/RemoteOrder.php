<?php

namespace Springbot\Main\Model\ResourceModel\Marketplaces;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class RedirectMongoId
 *
 * @package Springbot\Main\Model\ResourceModel\Marketplaces
 */
class RemoteOrder extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('springbot_marketplaces_remote_order', 'id');
    }
}
