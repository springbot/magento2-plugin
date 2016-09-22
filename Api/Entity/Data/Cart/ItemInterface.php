<?php

namespace Springbot\Main\Api\Entity\Data\Cart;

/**
 * Interface ItemInterface
 * @package Springbot\Main\Api\Entity\Data\Cart
 */
interface ItemInterface
{

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return string
     */
    public function getSkuFulfillment();

    /**
     * @return string
     */
    public function getQtyOrdered();

    /**
     * @return string
     */
    public function getLandingUrl();

    /**
     * @return string
     */
    public function getImageUrl();

    /**
     * @return string
     */
    public function getProductType();

}
