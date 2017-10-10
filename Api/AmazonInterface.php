<?php

namespace Springbot\Main\Api;

/**
 * Interface AmazonInterface
 * @package Springbot\Main\Api
 */
interface AmazonInterface
{

    /**
     * @param string $id
     * @param string $amazonOrderId
     * @param int $localStoreId
     * @param int $storeId
     * @param string $buyerEmail
     * @param string $buyerName
     * @param \Springbot\Main\Api\Amazon\Order\AddressInterface $shippingAddress
     * @param \Springbot\Main\Api\Amazon\Order\ItemInterface[]  $orderItems
     * @return \Springbot\Main\Api\Amazon\CreatedOrderInterface
     * @throws \Exception
     */
    public function createOrder($id, $amazonOrderId, $localStoreId, $storeId, $buyerEmail, $buyerName, $shippingAddress,
        $orderItems);

}
