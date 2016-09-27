<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Api\Entity
 */
class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $collection->addStoreFilter($storeId);
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection as $item) {
            $ret[] = $this->getFromId($storeId, $item->getId());
        }
        return $ret;
    }

    public function getFromId($storeId, $productId)
    {
        return $this->getSpringbotModel()->load($productId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Product');
    }
}
