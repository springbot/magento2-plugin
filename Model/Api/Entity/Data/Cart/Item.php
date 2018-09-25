<?php

namespace Springbot\Main\Model\Api\Entity\Data\Cart;

use Springbot\Main\Api\Entity\Data\Cart\ItemInterface;
use Springbot\Main\Model\Api\Entity\Data\ProductFactory;
use Springbot\Main\Model\Api\Entity\ProductRepository;

/**
 * Class Item
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Cart
 */
class Item implements ItemInterface
{
    private $storeId;
    private $name;
    private $productId;
    private $parentProductId;
    private $parentSku;
    private $sku;
    private $qty;
    private $productType;

    private $productRepository;
    private $product;

    /**
     * Customer constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function setValues($storeId, $name, $productId, $parentProductId, $sku, $parentSku, $qty, $productType)
    {
        $this->storeId = $storeId;
        $this->name = $name;
        $this->productId = $productId;
        $this->parentProductId = $parentProductId;
        $this->sku = $sku;
        $this->parentSku = $parentSku;
        $this->qty = $qty;
        $this->productType = $productType;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getParentProductId()
    {
        return $this->parentProductId;
    }

    public function getParentSku()
    {
        return $this->parentSku;
    }

    public function getQty()
    {
        return $this->qty;
    }

    private function getProduct()
    {
        if (isset($this->product)) {
            return $this->product;
        } else {
            if (! ($productId = $this->parentProductId)) {
                $productId = $this->productId;
            }
            $this->product = $this->productRepository->getFromId($this->storeId, $productId);
            return $this->product;
        }
    }

    public function getLandingUrl()
    {
        if ($product = $this->getProduct()) {
            return $product->getDefaultUrl();
        }
        return null;
    }

    public function getImageUrl()
    {
        if ($product = $this->getProduct()) {
            return $product->getImageUrl();
        }
        return null;
    }

    public function getProductType()
    {
        return $this->productType;
    }
}
