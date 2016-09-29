<?php

namespace Springbot\Main\Model\Api\Entity\Data\Order;

use Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface;
use Springbot\Main\Api\Entity\Data\Order\ItemInterface;

/**
 * Class Item
 * @package Springbot\Main\Model\Api\Entity\Data\Order
 */
class Item implements ItemInterface
{

    private $sku;
    private $skuFulfillment;
    private $qtyOrdered;
    private $landingUrl;
    private $imageUrl;
    private $wgt;
    private $name;
    private $desc;
    private $sellPrice;
    private $productId;
    private $productType;
    private $categoryIds;
    private $rootCategoryIds;
    private $allCategoryIds;
    private $attributeSetId;
    private $productAttributes;

    /**
     * @param $sku
     * @param $skuFulfillment
     * @param $qtyOrdered
     * @param $landingUrl
     * @param $imageUrl
     * @param $wgt
     * @param $name
     * @param $desc
     * @param $sellPrice
     * @param $productId
     * @param $productType
     * @param $categoryIds
     * @param $allCategoryIds
     * @param $attributeSetId
     * @param $productAttributes
     */
    public function setValues(
        $sku,
        $skuFulfillment,
        $qtyOrdered,
        $landingUrl,
        $imageUrl,
        $wgt,
        $name,
        $desc,
        $sellPrice,
        $productId,
        $productType,
        $categoryIds,
        $allCategoryIds,
        $attributeSetId,
        $productAttributes
    ) {
        $this->sku = $sku;
        $this->skuFulfillment = $skuFulfillment;
        $this->qtyOrdered = $qtyOrdered;
        $this->landingUrl = $landingUrl;
        $this->imageUrl = $imageUrl;
        $this->wgt = $wgt;
        $this->name = $name;
        $this->desc = $desc;
        $this->sellPrice = $sellPrice;
        $this->productId = $productId;
        $this->productType = $productType;
        $this->categoryIds = $categoryIds;
        $this->allCategoryIds = $allCategoryIds;
        $this->attributeSetId = $attributeSetId;
        $this->productAttributes = $productAttributes;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getSkuFulfillment()
    {
        return $this->skuFulfillment;
    }

    /**
     * @return mixed
     */
    public function getQtyOrdered()
    {
        return $this->qtyOrdered;
    }

    /**
     * @return mixed
     */
    public function getLandingUrl()
    {
        return $this->landingUrl;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return mixed
     */
    public function getWgt()
    {
        return $this->wgt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return mixed
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
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
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @return mixed
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    /**
     * @return mixed
     */
    public function getAllCategoryIds()
    {
        return $this->allCategoryIds;
    }

    /**
     * @return mixed
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    /**
     * @return ItemAttributeInterface[]
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

}
