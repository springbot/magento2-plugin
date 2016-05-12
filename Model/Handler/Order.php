<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Order extends Handler
{
    const API_PATH = 'orders';
    const ENTITIES_NAME = 'orders';

    /**
     * @param $storeId
     * @param $orderId
     * @throws \Exception
     */
    public function handle($storeId, $orderId)
    {
        $order = $this->objectManager->get('Magento\Sales\Model\Order')->load($orderId);
        /* @var MagentoOrder $order */
        $itemsArray = [];
        foreach ($order->getAllItems() as $item) {
            $itemsArray[] = $item->toArray();
        }
        $array = $order->toArray();
        $array['items'] = $itemsArray;
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    public function handleDelete($storeId, $orderId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $orderId]);
    }
}
