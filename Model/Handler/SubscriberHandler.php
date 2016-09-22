<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\SalesRule\Model\Rule as MagentoRule;

/**
 * Class SubscriberHandler
 * @package Springbot\Main\Model\Handler
 */
class SubscriberHandler extends Handler
{
    const API_PATH = 'subscribers';

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handle($storeId, $subscriberId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $subscriberId]);
    }

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handleDelete($storeId, $subscriberId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $subscriberId]);
    }
}
