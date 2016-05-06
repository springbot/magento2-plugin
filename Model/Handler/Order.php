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
        $Order = $objectManager->get('Magento\Catalog\Model\Order')->load($orderId);

        $parsed = $this->parse($Order, self::DATA_SOURCE_BH);
        $api = $objectManager->get('Springbot\Main\Model\Api');
        /* @var Api $api */
        $api->getApiUrl();
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
