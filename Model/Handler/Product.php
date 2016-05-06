<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Springbot\Main\Model\Parser\Product as ProductParser;
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

    public function handle($storeId, $productId)
    {
        $parser = new ProductParser();
        $objectManager = ObjectManager::getInstance();
        $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);

        $parsed = $parser->parse($product, self::DATA_SOURCE_BH);
        $api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        echo $api->getApiUrl();
    }
    
    public function handleDelete($storeId, $productId)
    {

    }

    /**
     * @param MagentoProduct $product
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoProduct $product, $dataSource)
    {
        return [
            'store_id' => $product->getStore()->getId(),
            'entity_id' => $product->getEntityId(),
            'sku' => $product->getSku(),
            'sku_fulfillment' => $product->getSku(),
            'category_ids' => $product->getCategoryIds(),
            'root_category_ids' => $product->getCategoryIds(),      // TODO
            'all_category_ids' => $product->getCategoryIds(),
            'full_description' => '',                               // TODO
            'short_description' => '',                              // TODO
            'image_url' => $product->getImage(),
            'landing_url' => $product->getProductUrl(),
            'name' => $product->getName(),
            'url_key' => $product->getUrlKey(),
            'is_deleted' => false,
            'status' => $product->getStatus(),
            'created_at' => $product->getCreatedAt(),
            'updated_at' => $product->getUpdatedAt(),
            'catalog_created_at' => $product->getCreatedAt(),
            'catalog_updated_at' => $product->getUpdatedAt(),
            'json_data' => [
                'unit_price' => $product->getPrice(),
                'msrp' => 0,                                        // TODO
                'sale_price' => $product->getSpecialPrice(),
                'unit_cost' => 0,                                   // TODO
                'image_label' => '',                                // TODO
                'unit_wgt' => $product->getWeight(),
                'type' => $product->getTypeId(),
                'visibility' => $product->getVisibility(),
                'cat_id_list' => '',                                // TODO
            ],
            'custom_attribute_set_id' => $product->getAttributeSetId(),
            'custom_attributes' => [],                              // TODO
            'data_source' => $dataSource
        ];
    }

}
