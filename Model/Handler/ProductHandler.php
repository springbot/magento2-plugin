<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class ProductHandler
 * @package Springbot\Main\Model\Handler
 */
class ProductHandler extends AbstractHandler
{
    const API_PATH = 'products';

    /**
     * @param int $storeId
     * @param int $productId
     */
    public function handle($storeId, $productId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $productId]);
    }

    /**
     * @param int $storeId
     * @param int $productId
     */
    public function handleDelete($storeId, $productId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $productId]);
    }
}
