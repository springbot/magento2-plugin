<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class OrderHandler
 * @package Springbot\Main\Model\Handler
 */
class OrderHandler extends AbstractHandler
{
    const API_PATH = 'orders';

    /**
     * @param int $storeId
     * @param int $orderId
     */
    public function handle($storeId, $orderId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $orderId]);
    }

    /**
     * @param int $storeId
     * @param int $orderId
     */
    public function handleDelete($storeId, $orderId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $orderId]);
    }
}
