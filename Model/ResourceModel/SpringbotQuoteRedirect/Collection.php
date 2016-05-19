<?php

namespace Springbot\Main\Model\ResourceModel\SpringbotQuoteRedirect;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define Model and ResourceModel
     */
    protected function _construct()
    {
        $this->_init(
            'Springbot\Main\Model\SpringbotQuoteRedirect',
            'Springbot\Main\Model\ResourceModel\SpringbotQuoteRedirect'
        );
    }
}
