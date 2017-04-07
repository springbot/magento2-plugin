<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class InventoryHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class InventoryHandler extends AbstractHandler
{
    const api_path = 'inventories';

    /**
     * @param int $storeId
     * @param int $inventoryId
     */
    public function handle($storeId, $inventoryId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $inventoryId]);
    }

    /**
     * @param int $storeId
     * @param int $categoryId
     */
    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $categoryId]);
    }
}
