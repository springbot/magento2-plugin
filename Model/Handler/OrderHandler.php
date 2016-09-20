<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class OrderHandler
 * @package Springbot\Main\Model\Handler
 */
class OrderHandler extends Handler
{
    const API_PATH = 'orders';

    /**
     * @param $storeId
     * @param $orderId
     * @throws \Exception
     */
    public function handle($storeId, $orderId)
    {
        $order = $this->objectManager->get('Springbot\Main\Api\Entity\Data\OrderInterface')->load($orderId);
        /* @var \Springbot\Main\Model\Entity\Data\Order $order */
        $data = $order->toArray();
        $data['items'] = $order->getItems();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $orderId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $orderId]);
    }
}
