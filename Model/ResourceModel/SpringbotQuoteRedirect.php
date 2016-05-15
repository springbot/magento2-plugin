<?php

namespace Springbot\Main\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class RedirectMongoId
 *
 * @package Springbot\Main\Model\ResourceModel
 */
class SpringbotQuoteRedirect extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('springbot_quote_redirect', 'id');
    }
}
