<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class OrderHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class OrderHandler extends AbstractHandler
{
    const api_path = 'orders';

    /**
     * @param int $storeId
     * @param int $orderId
     */
    public function handle($storeId, $orderId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $orderId]);
    }

    /**
     * @param int $storeId
     * @param int $orderId
     */
    public function handleDelete($storeId, $orderId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $orderId]);
    }
}
