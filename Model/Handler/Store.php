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
        $parser = new StoreParser();
        $objectManager = ObjectManager::getInstance();
        $store = $objectManager->get('Magento\Store\Model\Store')->load($storeId);

        $parsed = $parser->parse($store, self::DATA_SOURCE_BH);
        $api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        echo $api->getApiUrl();
    }
    
    public function handleDelete($storeId)
    {

    }

    /**
     * @param MagentoStore $store
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoStore $store, $dataSource)
    {
        return [];
    }

}
