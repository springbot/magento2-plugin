<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Springbot\Main\Model\Parser\Store as StoreParser; // Todo
use Magento\Store\Model\Store as MagentoStore;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class Store
 *
 * @package Springbot\Main\Model\Handler
 */
class Store extends Handler
{

    const API_PATH = 'stores';
    const ENTITIES_NAME = 'stores';

    public function handle($storeId)
    {

        $objectManager = ObjectManager::getInstance();
        $store = $objectManager->get('Magento\Store\Model\Store')->load($storeId);

        $api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        echo $api->getApiUrl();
    }
    
    public function handleDelete($storeId)
    {

    }


}
