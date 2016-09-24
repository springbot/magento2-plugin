<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\Entity\CategoryRepositoryInterface;

/**
 * CategoryRepository
 * @package Springbot\Main\Api
 */
class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    /**
     * @param int $storeId
     * @return \Springbot\Main\Model\Entity\Data\Category[]
     */
    public function getList($storeId)
    {
        $store = $this->getStoreModel()->load($storeId);
        $rootCategory = $this->getSpringbotModel()->load($store->getRootCategoryId());
        $collection = $this->getSpringbotModel()->getCollection();
        $collection->addFieldToFilter('path', array('like' => $rootCategory->getPath() . '%'));
        $this->filterResults($collection);
        $ret = array();
        $collection->load();
        foreach ($collection as $item) {
            $ret[] = $this->getFromId($storeId, $item->getId());
        }
        if ($ret) {
            $ret[] = $rootCategory;
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $categoryId
     * @return \Springbot\Main\Model\Entity\Data\Category
     */
    public function getFromId($storeId, $categoryId)
    {
        return $this->getSpringbotModel()->load($categoryId);
    }

    /**
     * @return \Springbot\Main\Model\Entity\Data\Category
     */
    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Category');;
    }
}
