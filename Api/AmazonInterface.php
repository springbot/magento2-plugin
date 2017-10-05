<?php

namespace Springbot\Main\Api;

/**
 * Interface AmazonInterface
 * @package Springbot\Main\Api
 */
interface AmazonInterface
{

    /**
     *  @param \Springbot\Main\Api\Amazon\Order\ItemInterface[] $orderItems
     *  @return int
     */
    public function createOrder($orderItems);

}
