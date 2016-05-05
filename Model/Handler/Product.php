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
        echo $api->getApiUrl(); die;
    }
    
    public function handleDelete($storeId, $productId)
    {

    }

}
