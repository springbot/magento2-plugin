<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
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
    const API_PATH = 'Categories';
    const ENTITIES_NAME = 'Categories';

    public function handle($storeId, $categoryId)
    {

    }

    public function handleDelete($storeId, $categoryId)
    {

    }

    /**
     * @param MagentoCategory $category
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoCategory $category, $dataSource)
    {
        return [];
    }

}
