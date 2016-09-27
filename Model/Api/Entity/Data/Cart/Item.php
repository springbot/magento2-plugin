<?php

namespace Springbot\Main\Model\Api\Entity\Data\Cart;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Item
 * @package Springbot\Main\Model\Api\Entity\Data\Order
 */
class Item extends AbstractModel
{

    private $sku;
    private $skuFulfillment;
    private $qtyOrdered;
    private $landingUrl;
    private $imageUrl;
    private $productType;

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
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
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @param mixed $skuFulfillment
     */
    public function setSkuFulfillment($skuFulfillment)
    {
        $this->skuFulfillment = $skuFulfillment;
    }

    /**
     * @param mixed $qtyOrdered
     */
    public function setQtyOrdered($qtyOrdered)
    {
        $this->qtyOrdered = $qtyOrdered;
    }

    /**
     * @param mixed $landingUrl
     */
    public function setLandingUrl($landingUrl)
    {
        $this->landingUrl = $landingUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param mixed $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

}
