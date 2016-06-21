<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Springbot\Main\Model\Parser\Store as StoreParser; // Todo
use Magento\Store\Model\Store as MagentoStore;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class StoreHandler
 * @package Springbot\Main\Model\Handler
 */
class StoreHandler extends Handler
{
    const API_PATH = 'stores';

    public function handle($storeId, $id)
    {
        $store = $this->objectManager->get('Magento\Store\Model\Store')->load($storeId);
        /* @var \Magento\Store\Model\Store $store */
        $data = $store->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $id)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $storeId]);
    }
}
