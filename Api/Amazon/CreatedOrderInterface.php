<?php

namespace Springbot\Main\Api\Amazon;

/**
 * Interface ItemInterface
 * @package Springbot\Main\Api\Amazon
 */
interface CreatedOrderInterface
{

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getAmazonOrderId();

    /**
     * @return string
     */
    public function getOrderId();

    /**
     * @return int
     */
    public function getStoreId();
}
