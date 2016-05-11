<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
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
        $objectManager = ObjectManager::getInstance();

        $appState = $objectManager->get('Magento\Framework\App\State');
        /* @var \Magento\Framework\App\State $appState */
        $appState->setAreaCode("adminhtml");

        $product = $objectManager->get('Magento\Catalog\Model\Product');
        $product->load($productId);
        $product->setStoreId($storeId);

        /* @var MagentoProduct $product */

        $array = json_decode($product->toJson(), true);
        $array['landing_url'] = $product->getUrlInStore();
        print_r($array);

        //$api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        //$api->postEntities($storeId, 'products', 'products', [$array]);

        //echo $api->getApiUrl();
        throw new \Exception('xxx');
    }

    public function handleDelete($storeId, $productId)
    {

    }



}
