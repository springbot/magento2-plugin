<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class CartHandler
 * @package Springbot\Main\Model\Handler
 */
class CartHandler extends AbstractHandler
{
    const API_PATH = 'carts';

    /**
     * @param int $storeId
     * @param int $cartId
     */
    public function handle($storeId, $cartId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $cartId]);
    }

    /**
     * @param int $storeId
     * @param int $cartId
     */
    public function handleDelete($storeId, $cartId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $cartId]);
    }
}
