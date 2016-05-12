<?php

namespace Springbot\Main\Model\Handler;

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

    /**
     * @param $storeId
     * @param $customerId
     * @throws \Exception
     */
    public function handle($storeId, $customerId)
    {
        $customer = $this->objectManager->get('Magento\Customer\Model\Customer')->load($customerId);
        /* @var MagentoOrder $customer */
        $array = $customer->toArray();
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    public function handleDelete($storeId, $customerId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $customerId]);
    }
}
