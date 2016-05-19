<?php

namespace Springbot\Main\Model\ResourceModel\SpringbotOrderRedirect;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define Model and ResourceModel
     */
    protected function _construct()
    {
        $this->_init(
            'Springbot\Main\Model\SpringbotOrderRedirect',
            'Springbot\Main\Model\ResourceModel\SpringbotOrderRedirect'
        );
    }
}
