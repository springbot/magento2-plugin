<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Model\Handler;

/**
 * Class InventoryHandler
 * @package Springbot\Main\Model\Handler
 */
class InventoryHandler extends Handler
{
    const API_PATH = 'inventories';

    /**
     * @param int $storeId
     * @param int $inventoryId
     */
    public function handle($storeId, $inventoryId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $inventoryId]);
    }

    /**
     * @param int $storeId
     * @param int $categoryId
     */
    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $categoryId]);
    }
}
