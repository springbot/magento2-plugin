<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * Interface ItemInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface ItemInterface
{

    /**
     * @param $storeId
     * @param $sku
     * @param $skuFulfillment
     * @param $qtyOrdered
     * @param $wgt
     * @param $name
     * @param $sellPrice
     * @param $productId
     * @param $parentProductId
     * @param $productType
     * @return void
     */
    public function setValues(
        $storeId,
        $sku,
        $skuFulfillment,
        $qtyOrdered,
        $wgt,
        $name,
        $sellPrice,
        $productId,
        $parentProductId,
        $productType
    );

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
    public function getWgt();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDesc();

    /**
     * @return string
     */
    public function getSellPrice();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return int
     */
    public function getParentProductId();

    /**
     * @return string
     */
    public function getProductType();

    /**
     * @return int[]
     */
    public function getCategoryIds();

    /**
     * @return int[]
     */
    public function getAllCategoryIds();

    /**
     * @return int
     */
    public function getAttributeSetId();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface[]
     */
    public function getProductAttributes();
}
