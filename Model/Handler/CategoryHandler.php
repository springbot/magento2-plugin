<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Category as MagentoCategory;

/**
 * Class CategoryHandler
 * @package Springbot\Main\Model\Handler
 */
class CategoryHandler extends Handler
{
    const API_PATH = 'categories';

    /**
     * @param $storeId
     * @param $categoryId
     * @throws \Exception
     */
    public function handle($storeId, $categoryId)
    {
        $category = $this->objectManager->get('Springbot\Main\Api\Entity\Data\CategoryInterface')->load($categoryId);
        /* @var \Springbot\Main\Model\Entity\Data\Category $category */
        $data = $category->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $categoryId]);
    }
}
