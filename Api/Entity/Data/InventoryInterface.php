<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface InventoryInterface
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface InventoryInterface
{

    /**
     * Inventory constructor.
     *
     * @param  $storeId
     * @param  $productId
     * @param  $systemManaged
     * @param  $outOfStockQty
     * @param  $quantity
     * @param  $itemId
     * @param  $isInStock
     * @param  $minSaleQty
     * @param  $skuFulfillment
     * @return void
     */
    public function setValues(
        $storeId,
        $productId,
        $systemManaged,
        $outOfStockQty,
        $quantity,
        $itemId,
        $isInStock,
        $minSaleQty,
        $skuFulfillment
    );

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return bool
     */
    public function getSystemManaged();

    /**
     * @return string
     */
    public function getOutOfStockQty();

    /**
     * @return string
     */
    public function getQuantity();

    /**
     * @return int
     */
    public function getItemId();

    /**
     * @return bool
     */
    public function getIsInStock();

    /**
     * @return string
     */
    public function getMinSaleQty();

    /**
     * @return string[]
     */
    public function getParentSkus();

    /**
     * @return string
     */
    public function getSkuFulfillment();
}
