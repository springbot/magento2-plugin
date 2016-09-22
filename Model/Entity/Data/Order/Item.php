<?php

namespace Springbot\Main\Model\Entity\Data\Order;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface;
use Springbot\Main\Api\Entity\Data\Order\ItemInterface;

/**
 * Class Item
 * @package Springbot\Main\Model\Entity\Data\Order
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
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getSkuFulfillment()
    {
        return $this->skuFulfillment;
    }

    /**
     * @param mixed $skuFulfillment
     */
    public function setSkuFulfillment($skuFulfillment)
    {
        $this->skuFulfillment = $skuFulfillment;
    }

    /**
     * @return mixed
     */
    public function getQtyOrdered()
    {
        return $this->qtyOrdered;
    }

    /**
     * @param mixed $qtyOrdered
     */
    public function setQtyOrdered($qtyOrdered)
    {
        $this->qtyOrdered = $qtyOrdered;
    }

    /**
     * @return mixed
     */
    public function getLandingUrl()
    {
        return $this->landingUrl;
    }

    /**
     * @param mixed $landingUrl
     */
    public function setLandingUrl($landingUrl)
    {
        $this->landingUrl = $landingUrl;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getWgt()
    {
        return $this->wgt;
    }

    /**
     * @param mixed $wgt
     */
    public function setWgt($wgt)
    {
        $this->wgt = $wgt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * @param mixed $sellPrice
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param mixed $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return mixed
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    /**
     * @param mixed $categoryIds
     */
    public function setCategoryIds($categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @return mixed
     */
    public function getRootCategoryIds()
    {
        return $this->rootCategoryIds;
    }

    /**
     * @param mixed $rootCategoryIds
     */
    public function setRootCategoryIds($rootCategoryIds)
    {
        $this->rootCategoryIds = $rootCategoryIds;
    }

    /**
     * @return mixed
     */
    public function getAllCategoryIds()
    {
        return $this->allCategoryIds;
    }

    /**
     * @param mixed $allCategoryIds
     */
    public function setAllCategoryIds($allCategoryIds)
    {
        $this->allCategoryIds = $allCategoryIds;
    }

    /**
     * @return mixed
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    /**
     * @param mixed $attributeSetId
     */
    public function setAttributeSetId($attributeSetId)
    {
        $this->attributeSetId = $attributeSetId;
    }

    /**
     * @return ItemAttributeInterface[]
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    /**
     * @param ItemAttributeInterface[] $productAttributes
     */
    public function setProductAttributes($productAttributes)
    {
        $this->productAttributes = $productAttributes;
    }

}
