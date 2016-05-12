<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Category as MagentoCategory;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Category extends Handler
{
    const API_PATH = 'categories';
    const ENTITIES_NAME = 'categories';

    /**
     * @param $storeId
     * @param $categoryId
     * @throws \Exception
     */
    public function handle($storeId, $categoryId)
    {
        $category = $this->objectManager->get('Magento\Catalog\Model\Category')->load($categoryId);
        /* @var MagentoCategory $category */
        $array = $category->toArray();
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $categoryId]);
    }
}
