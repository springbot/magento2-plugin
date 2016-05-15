<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Model\Handler;

/**
 * Class InventoryHandler
 * @package Springbot\Main\Model\Handler
 */
class InventoryHandler extends Handler
{
    const API_PATH = 'categories';

    /**
     * @param $storeId
     * @param $inventoryId
     * @throws \Exception
     */
    public function handle($storeId, $inventoryId)
    {
        $inventory = $this->objectManager->get('Springbot\Main\Api\Entity\Data\InventoryInterface')->load($inventoryId);
        /* @var \Springbot\Main\Model\Entity\Data\Inventory $inventory */
        $data = $inventory->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $categoryId]);
    }
}
