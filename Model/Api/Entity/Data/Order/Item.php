<?php

namespace Springbot\Main\Model\Api\Entity\Data\Order;

use Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface;
use Springbot\Main\Api\Entity\Data\Order\ItemInterface;
use Springbot\Main\Api\Entity\Data\ProductInterface;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;

/**
 * Class Item
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Order
 */
class Item implements ItemInterface
{

    private $storeId;
    private $sku;
    private $skuFulfillment;
    private $qtyOrdered;
    private $wgt;
    private $name;
    private $sellPrice;
    private $productId;
    private $parentProductId;
    private $productType;

    /* @var ProductInterface $product */
    private $product;
    private $childProduct = null;
    private $productRepository;

    /**
     * @param \Springbot\Main\Api\Entity\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

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
    ) {
        $this->storeId = $storeId;
        $this->sku = $sku;
        $this->skuFulfillment = $skuFulfillment;
        $this->qtyOrdered = $qtyOrdered;
        $this->wgt = $wgt;
        $this->name = $name;
        $this->sellPrice = $sellPrice;
        $this->productId = $productId;
        $this->parentProductId = $parentProductId;
        $this->productType = $productType;
        if ($parentProductId) {
            $this->product = $this->productRepository->getFromId($this->storeId, $parentProductId);
            $this->childProduct = $this->productRepository->getFromId($this->storeId, $productId);
        } else {
            $this->product = $this->productRepository->getFromId($this->storeId, $productId);
        }
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
    public function getParentProductId()
    {
        return $this->parentProductId;
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
    public function getLandingUrl()
    {
        if ($this->product) {
            return $this->product->getDefaultUrl();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        if ($this->product) {
            if ($url = $this->product->getImageUrl()) {
                return $url;
            } elseif ($this->childProduct) {
                return $this->childProduct->getImageUrl();
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        if ($this->product) {
            return $this->product->getDescription();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getCategoryIds()
    {
        if ($this->product) {
            return $this->product->getCategoryIds();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getAllCategoryIds()
    {
        if ($this->product) {
            return $this->product->getAllCategoryIds();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getAttributeSetId()
    {
        if ($this->product) {
            return $this->product->getCustomAttributeSetId();
        }
        return null;
    }

    /**
     * @return ItemAttributeInterface[]
     */
    public function getProductAttributes()
    {
        if ($this->product) {
            return $this->product->getProductAttributes();
        }
        return null;
    }
}
