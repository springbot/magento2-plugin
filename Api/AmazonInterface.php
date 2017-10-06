<?php

namespace Springbot\Main\Api;

/**
 * Interface AmazonInterface
 * @package Springbot\Main\Api
 */
interface AmazonInterface
{

    /**
     * @param int $localStoreId
     * @param int $storeId
     * @param string $buyerEmail
     * @param string $buyerName
     * @param \Springbot\Main\Api\Amazon\Order\AddressInterface $shippingAddress
     * @param \Springbot\Main\Api\Amazon\Order\ItemInterface[]  $orderItems
     * @return int
     * @throws \Exception
     */
    public function createOrder($localStoreId, $storeId, $buyerEmail, $buyerName, $shippingAddress, $orderItems);

}
