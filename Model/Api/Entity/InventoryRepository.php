<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\InventoryRepositoryInterface;
use Magento\Framework\App\ObjectManager;


/**
 *  InventoryRepository
 * @package Springbot\Main\Api
 */
class InventoryRepository extends AbstractRepository implements InventoryRepositoryInterface
{

    public function getList($storeId)
    {
        $store = ObjectManager::getInstance()->get('Magento\Store\Model\StoreManagerInterface')->getStore($storeId);
        if (!$store->getData()) {
            throw new \Exception("Store not found, store_id {$storeId}", 404);
        }
        $resource = $this->objectManager->create('Magento\CatalogInventory\Model\ResourceModel\Stock\Item');
        $select = $resource->getConnection()->select()->from($resource->getMainTable());
        $select->where('website_id', $storeId);
        $stockItemRows = $resource->getConnection()->fetchAll($select);
        $stockItems = [];
        foreach ($stockItemRows  as $stockItemRow) {
            $stockItems[] = $this->getSpringbotModel()->setData($stockItemRow);
        }
        return $stockItems;
    }

    public function getFromId($storeId, $inventoryId)
    {
        return $this->getSpringbotModel()->load($inventoryId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Inventory');
    }
}
