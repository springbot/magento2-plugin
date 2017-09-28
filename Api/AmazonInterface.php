<?php

namespace Springbot\Main\Api;

/**
 * Interface AmazonInterface
 * @package Springbot\Main\Api
 */
interface AmazonInterface
{

    /**
     * @param string $order
     * @return string|null
     */
    public function createOrder($order);

}
