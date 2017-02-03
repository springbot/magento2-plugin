<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * Interface ShipmentItemInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface ShipmentItemInterface
{

    /**
     * ShipmentItem constructor.
     *
     * @param  $sku
     * @param  $name
     * @param  $productId
     * @param  $qty
     * @return void
     */
    public function setValues($sku, $name, $productId, $qty);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return string
     */
    public function getQty();
}
