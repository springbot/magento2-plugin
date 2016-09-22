<?php

namespace Springbot\Main\Model\Handler;

use Magento\Catalog\Model\Product as MagentoProduct;
use Magento\Framework\App\ObjectManager;
use Springbot\Main\Model\Entity\Data\Product;
use Springbot\Main\Model\Handler;
use Springbot\Main\Model\Entity\Data\ProductFactory;

/**
 * Class ProductHandler
 * @package Springbot\Main\Model\Handler
 */
class ProductHandler extends Handler
{
    const API_PATH = 'products';

    /**
     * @param int $storeId
     * @param int $productId
     */
    public function handle($storeId, $productId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $productId]);
    }

    /**
     * @param int $storeId
     * @param int $productId
     */
    public function handleDelete($storeId, $productId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $productId]);
    }
}
