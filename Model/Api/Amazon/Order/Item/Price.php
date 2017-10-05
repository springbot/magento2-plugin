<?php

namespace Springbot\Main\Model\Api\Amazon\Order\Item;

use Springbot\Main\Api\Amazon\Order\Item\PriceInterface;

/**
 * Class Price
 * @package Springbot\Main\Model\Api\Amazon\Order
 */
class Price implements PriceInterface
{

    private $Amount;
    private $CurrencyCode;

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param mixed $Amount
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->CurrencyCode;
    }

    /**
     * @param mixed $CurrencyCode
     */
    public function setCurrencyCode($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
    }



}
