<?php

namespace Springbot\Main\Api\Entity\Data\Cart;

/**
 * Interface ItemInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Cart
 */
interface ItemInterface
{

    /**
     * @param $storeId
     * @param $name
     * @param $productId
     * @param $parentProductId
     * @param $sku
     * @param $parentSku
     * @param $qty
     * @param $productType
     * @return void
     */
    public function setValues($storeId, $name, $productId, $parentProductId, $sku, $parentSku, $qty, $productType);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return string
     */
    public function getParentSku();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return int
     */
    public function getParentProductId();

    /**
     * @return int
     */
    public function getName();

    /**
     * @return string
     */
    public function getQty();

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
