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
     * @param int $storeId
     * @param int $categoryId
     */
    public function handle($storeId, $categoryId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $categoryId]);
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
