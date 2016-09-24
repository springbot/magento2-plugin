<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\InventoryRepositoryInterface;

/**
 *  InventoryRepository
 * @package Springbot\Main\Api
 */
class InventoryRepository extends AbstractRepository implements InventoryRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $array = $collection->toArray();
        return $array['items'];
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
