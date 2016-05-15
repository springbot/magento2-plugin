<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Model\Customer as MagentoCustomer;

/**
 * Class CustomerHandler
 * @package Springbot\Main\Model\Handler
 */
class CustomerHandler extends Handler
{
    const API_PATH = 'customers';

    /**
     * @param $storeId
     * @param $customerId
     * @throws \Exception
     */
    public function handle($storeId, $customerId)
    {
        $customer = $this->objectManager->get('Springbot\Main\Api\Entity\Data\CouponInterface')->load($customerId);
        /* @var \Springbot\Main\Model\Entity\Data\Customer $customer */
        $data = $customer->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $customerId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $customerId]);
    }
}
