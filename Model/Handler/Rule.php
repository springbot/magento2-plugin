<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\SalesRule\Model\Rule as MagentoRule;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Rule extends Handler
{
    const API_PATH = 'promotions';
    const ENTITIES_NAME = 'promotions';

    public function handle($storeId, $cartId)
    {

    }

    public function handleDelete($storeId, $cartId)
    {

    }

    /**
     * @param MagentoRule $rule
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoRule $rule, $dataSource)
    {

        return [];
    }

}
