<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\CategoryRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Store\Model\Store;

/**
 *  CategoryRepository
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
        $collection = $rootCategory->getChildrenCategories();
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection->getAllIds() as $id) {
            $ret[] = $this->getFromId($storeId, $id);
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
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Category');
        ;
    }
}
