<?php

namespace Springbot\Main\Model\Api\Amazon\Order;

use Springbot\Main\Api\Amazon\Order\ItemInterface;

/**
 * Class Item
 *
 * @package Springbot\Main\Model
 */
class Item implements ItemInterface
{

    private $id;
    private $amazonOrderId;
    private $asin;
    private $sellerSku;
    private $orderItemId;
    private $title;
    private $quantityOrdered;
    private $quantityShipped;
    private $pointsGranted;
    private $itemPrice;
    private $shippingPrice;
    private $giftWrapPrice;
    private $itemTax;
    private $shippingTax;
    private $giftWrapTax;
    private $shippingDiscount;
    private $promotionDiscount;
    private $promotionIds;
    private $codFee;
    private $codFeeDiscount;
    private $giftMessageText;
    private $giftWrapLevel;
    private $invoiceData;
    private $conditionNote;
    private $conditionId;
    private $conditionSubtypeId;
    private $scheduledDeliveryStartDate;
    private $scheduledDeliveryEndDate;
    private $priceDesignation;
    private $createdAt;
    private $updatedAt;
    private $storeId;
    private $productId;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAmazonOrderId()
    {
        return $this->amazonOrderId;
    }

    /**
     * @param string $amazonOrderId
     */
    public function setAmazonOrderId($amazonOrderId)
    {
        $this->amazonOrderId = $amazonOrderId;
    }

    /**
     * @return string
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    public function setAsin($asin)
    {
        $this->asin = $asin;
    }

    /**
     * @return string
     */
    public function getSellerSku()
    {
        return $this->sellerSku;
    }

    /**
     * @param string $sellerSku
     */
    public function setSellerSku($sellerSku)
    {
        $this->sellerSku = $sellerSku;
    }

    /**
     * @return string
     */
    public function getOrderItemId()
    {
        return $this->orderItemId;
    }

    /**
     * @param string $orderItemId
     */
    public function setOrderItemId($orderItemId)
    {
        $this->orderItemId = $orderItemId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getQuantityOrdered()
    {
        return $this->quantityOrdered;
    }

    /**
     * @param string $quantityOrdered
     */
    public function setQuantityOrdered($quantityOrdered)
    {
        $this->quantityOrdered = $quantityOrdered;
    }

    /**
     * @return string
     */
    public function getQuantityShipped()
    {
        return $this->quantityShipped;
    }

    /**
     * @param string $quantityShipped
     */
    public function setQuantityShipped($quantityShipped)
    {
        $this->quantityShipped = $quantityShipped;
    }

    /**
     * @return string
     */
    public function getPointsGranted()
    {
        return $this->pointsGranted;
    }

    /**
     * @param string $pointsGranted
     */
    public function setPointsGranted($pointsGranted)
    {
        $this->pointsGranted = $pointsGranted;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $itemPrice
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingPrice
     */
    public function setShippingPrice($shippingPrice)
    {
        $this->shippingPrice = $shippingPrice;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getGiftWrapPrice()
    {
        return $this->giftWrapPrice;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $giftWrapPrice
     */
    public function setGiftWrapPrice($giftWrapPrice)
    {
        $this->giftWrapPrice = $giftWrapPrice;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getItemTax()
    {
        return $this->itemTax;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $itemTax
     */
    public function setItemTax($itemTax)
    {
        $this->itemTax = $itemTax;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingTax()
    {
        return $this->shippingTax;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingTax
     */
    public function setShippingTax($shippingTax)
    {
        $this->shippingTax = $shippingTax;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getGiftWrapTax()
    {
        return $this->giftWrapTax;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $giftWrapTax
     */
    public function setGiftWrapTax($giftWrapTax)
    {
        $this->giftWrapTax = $giftWrapTax;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingDiscount()
    {
        return $this->shippingDiscount;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingDiscount
     */
    public function setShippingDiscount($shippingDiscount)
    {
        $this->shippingDiscount = $shippingDiscount;
    }

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getPromotionDiscount()
    {
        return $this->promotionDiscount;
    }

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $promotionDiscount
     */
    public function setPromotionDiscount($promotionDiscount)
    {
        $this->promotionDiscount = $promotionDiscount;
    }

    /**
     * @return string
     */
    public function getPromotionIds()
    {
        return $this->promotionIds;
    }

    /**
     * @param string $promotionIds
     */
    public function setPromotionIds($promotionIds)
    {
        $this->promotionIds = $promotionIds;
    }

    /**
     * @return string
     */
    public function getCodFee()
    {
        return $this->codFee;
    }

    /**
     * @param string $codFee
     */
    public function setCodFee($codFee)
    {
        $this->codFee = $codFee;
    }

    /**
     * @return string
     */
    public function getCodFeeDiscount()
    {
        return $this->codFeeDiscount;
    }

    /**
     * @param string $codFeeDiscount
     */
    public function setCodFeeDiscount($codFeeDiscount)
    {
        $this->codFeeDiscount = $codFeeDiscount;
    }

    /**
     * @return string
     */
    public function getGiftMessageText()
    {
        return $this->giftMessageText;
    }

    /**
     * @param string $giftMessageText
     */
    public function setGiftMessageText($giftMessageText)
    {
        $this->giftMessageText = $giftMessageText;
    }

    /**
     * @return string
     */
    public function getGiftWrapLevel()
    {
        return $this->giftWrapLevel;
    }

    /**
     * @param string $giftWrapLevel
     */
    public function setGiftWrapLevel($giftWrapLevel)
    {
        $this->giftWrapLevel = $giftWrapLevel;
    }

    /**
     * @return string
     */
    public function getInvoiceData()
    {
        return $this->invoiceData;
    }

    /**
     * @param string $invoiceData
     */
    public function setInvoiceData($invoiceData)
    {
        $this->invoiceData = $invoiceData;
    }

    /**
     * @return string
     */
    public function getConditionNote()
    {
        return $this->conditionNote;
    }

    /**
     * @param string $conditionNote
     */
    public function setConditionNote($conditionNote)
    {
        $this->conditionNote = $conditionNote;
    }

    /**
     * @return string
     */
    public function getConditionId()
    {
        return $this->conditionId;
    }

    /**
     * @param string $conditionId
     */
    public function setConditionId($conditionId)
    {
        $this->conditionId = $conditionId;
    }

    /**
     * @return string
     */
    public function getConditionSubtypeId()
    {
        return $this->conditionSubtypeId;
    }

    /**
     * @param string $conditionSubtypeId
     */
    public function setConditionSubtypeId($conditionSubtypeId)
    {
        $this->conditionSubtypeId = $conditionSubtypeId;
    }

    /**
     * @return string
     */
    public function getScheduledDeliveryStartDate()
    {
        return $this->scheduledDeliveryStartDate;
    }

    /**
     * @param string $scheduledDeliveryStartDate
     */
    public function setScheduledDeliveryStartDate($scheduledDeliveryStartDate)
    {
        $this->scheduledDeliveryStartDate = $scheduledDeliveryStartDate;
    }

    /**
     * @return string
     */
    public function getScheduledDeliveryEndDate()
    {
        return $this->scheduledDeliveryEndDate;
    }

    /**
     * @param string $scheduledDeliveryEndDate
     */
    public function setScheduledDeliveryEndDate($scheduledDeliveryEndDate)
    {
        $this->scheduledDeliveryEndDate = $scheduledDeliveryEndDate;
    }

    /**
     * @return string
     */
    public function getPriceDesignation()
    {
        return $this->priceDesignation;
    }

    /**
     * @param string $priceDesignation
     */
    public function setPriceDesignation($priceDesignation)
    {
        $this->priceDesignation = $priceDesignation;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @param string $storeId
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }
}
