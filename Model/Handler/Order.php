<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;


/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Order extends Handler
{
    const API_PATH = 'orders';
    const ENTITIES_NAME = 'orders';

    public function handle($storeId, $orderId)
    {
        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order')->load($orderId);
        /* @var MagentoOrder $order */
        foreach ($order->getAllItems() as $item) {
            $array = json_decode($item->toJson(), true);
            print_r($array);
        }
        $array = json_decode($order->toJson(), true);
        print_r($array);

        //$api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        //$api->postEntities($storeId, 'products', 'products', [$array]);
        //echo $api->getApiUrl();
        throw new \Exception('xxx');
    }

    public function handleDelete($storeId, $orderId)
    {

    }

    /**
     * @param MagentoOrder $order
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoOrder $order, $dataSource)
    {
        return [];
    }

}
