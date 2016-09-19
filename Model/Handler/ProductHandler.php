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

    public function handle($storeId, $productId)
    {
        $product = $this->objectManager->get('Springbot\Main\Api\Entity\Data\ProductInterface')->load($productId);
        /* @var \Springbot\Main\Model\Entity\Data\Product $product */
        $data = $product->toArray();
        $data['default_url'] = $product->getDefaultUrl();
        $data['url_in_store'] = $product->getUrlInStore();
        $data['url_id_path'] = $product->getUrlIdPath();
        $data['image_url'] = $product->getImageUrl();
        $data['parent_skus'] = $product->getParentSkus();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $productId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $productId]);
    }
}
