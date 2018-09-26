<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\InventoryInterface;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Inventory
 *
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Inventory implements InventoryInterface
{
    public $storeId;
    public $productId;
    public $systemManaged;
    public $outOfStockQty;
    public $quantity;
    public $itemId;
    public $isInStock;
    public $minSaleQty;
    public $skuFulfillment;

    private $connectionResource;

    /**
     * Inventory constructor.
     *
     * @param \Magento\Framework\App\ResourceConnection $connectionResource
     */
    public function __construct(ResourceConnection $connectionResource)
    {
        $this->connectionResource = $connectionResource;
    }

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
    ) {
        $this->storeId = $storeId;
        $this->productId = $productId;
        $this->systemManaged = $systemManaged;
        $this->outOfStockQty = $outOfStockQty;
        $this->quantity = $quantity;
        $this->itemId = $itemId;
        $this->isInStock = $isInStock;
        $this->minSaleQty = $minSaleQty;
        $this->skuFulfillment = $skuFulfillment;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getSystemManaged()
    {
        return $this->systemManaged;
    }

    /**
     * @return mixed
     */
    public function getOutOfStockQty()
    {
        return $this->outOfStockQty;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return mixed
     */
    public function getIsInStock()
    {
        return $this->isInStock;
    }

    /**
     * @return mixed
     */
    public function getMinSaleQty()
    {
        return $this->minSaleQty;
    }

    /**
     * @return mixed
     */
    public function getSkuFulfillment()
    {
        return $this->skuFulfillment;
    }

    /**
     * @return string[]
     */
    public function getParentSkus()
    {
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $query = $conn->query(
            "SELECT cpe.sku FROM {$resource->getTableName('catalog_product_relation')} cper
            LEFT JOIN {$resource->getTableName('catalog_product_entity')} cpe
              ON (cper.parent_id = cpe.entity_id)
                WHERE cper.child_id = :entity_id",
            ['entity_id' => $this->productId]
        );
        $skus = [];
        foreach ($query->fetchAll() as $parentRow) {
            $skus[] = $parentRow['sku'];
        }
        return $skus;
    }
}
