<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface InventoryInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface InventoryInterface
{
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
     * @return array
     */
    public function getParentSkus();

    /**
     * @return string
     */
    public function getSkuFulfillment();

}
