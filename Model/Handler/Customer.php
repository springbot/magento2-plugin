<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Model\Customer as MagentoCustomer;


/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Customer extends Handler
{
    const API_PATH = 'customers';
    const ENTITIES_NAME = 'customers';

    public function handle($storeId, $customerId)
    {

    }

    public function handleDelete($storeId, $customerId)
    {

    }

    /**
     * @param MagentoCustomer $customer
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoCustomer $customer, $dataSource)
    {
        return [];
    }

}
