<?php

namespace Springbot\Main\Api\Amazon\Order\Item;

/**
 * Interface PriceInterface
 * @package Springbot\Main\Api\Amazon\Order\Item
 */
interface PriceInterface
{

    /**
     * @return string
     */
    public function getAmount();

    /**
     * @param string $Amount
     */
    public function setAmount($Amount);

    /**
     * @return string
     */
    public function getCurrencyCode();

    /**
     * @param string $CurrencyCode
     */
    public function setCurrencyCode($CurrencyCode);
}
