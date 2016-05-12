<?php

namespace Springbot\Main\Model\Handler;

use Magento\Catalog\Model\Product as MagentoProduct;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class Product
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends Handler
{

    const API_PATH = 'products';
    const ENTITIES_NAME = 'products';

    /**
     * @param $storeId
     * @param $productId
     * @throws \Exception
     */
    public function handle($storeId, $productId)
    {
        $product = $this->objectManager->get('Magento\Catalog\Model\Product');
        $product->load($productId);
        $product->setStoreId($storeId);
        /* @var MagentoProduct $product */
        $array = $product->toArray();
        $array['landing_url'] = $product->getUrlInStore();
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    public function handleDelete($storeId, $productId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $productId]);
    }
}
