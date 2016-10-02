<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Customer\Model\Customer as MagentoCustomer;

/**
 * Class CustomerHandler
 * @package Springbot\Main\Model\Handler
 */
class CustomerHandler extends Handler
{
    const API_PATH = 'customers';

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handle($storeId, $customerId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $customerId]);
    }

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handleDelete($storeId, $customerId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $customerId]);
    }
}
