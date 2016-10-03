<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * MarketplacesInterface
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface MarketplacesInterface
{
    /**
     * @return mixed $currencyCode.
     */
    public function getCurrencyCode();

    /**
     * @param mixed $currencycode
     * @return $this
     */
    public function setCurrencyCode($currencyCode);

    /**
     * @return float $shippingTotal.
     */
    public function getShippingTotal();

    /**
     * @param mixed $shippingTotal
     * @return $this
     */
    public function setShippingTotal($shippingTotal);

    /**
     * @return float $shippingTax.
     */
    public function getShippingTax();

    /**
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax);

    /**
     * @return float $tax.
     */
    public function getTax();

    /**
     * @param float $tax
     * @return $this
     */
    public function setTax($tax);

    /**
     * @return string|mixed region.
     */
    public function getRegion();

    /**
     * @param string|mixed $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * @return string $marketplaceType.
     */
    public function getMarketplaceType();

    /**
     * @param string $marketplaceType
     * @return $this
     */
    public function setMarketplaceType($marketplaceType);

    /**
     * @return string $remoteOrderId.
     */
    public function getRemoteOrderId();

    /**
     * @param string $remoteOrderId
     * @return $this
     */
    public function setRemoteOrderId($remoteOrderId);
}
