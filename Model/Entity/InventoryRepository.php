<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\InventoryRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

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
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Inventory');
    }
}
