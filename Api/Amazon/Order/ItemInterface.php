<?php

namespace Springbot\Main\Api\Amazon\Order;

/**
 * Interface ItemInterface
 * @package Springbot\Main\Api\Amazon\Order
 */
interface ItemInterface
{

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);
    /**
     * @return string
     */
    public function getAmazonOrderId();

    /**
     * @param string $amazonOrderId
     */
    public function setAmazonOrderId($amazonOrderId);

    /**
     * @return string
     */
    public function getAsin();

    /**
     * @param string $asin
     */
    public function setAsin($asin);

    /**
     * @return string
     */
    public function getSellerSku();

    /**
     * @param string $sellerSku
     */
    public function setSellerSku($sellerSku);

    /**
     * @return string
     */
    public function getOrderItemId();

    /**
     * @param string $orderItemId
     */
    public function setOrderItemId($orderItemId);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getQuantityOrdered();

    /**
     * @param string $quantityOrdered
     */
    public function setQuantityOrdered($quantityOrdered);

    /**
     * @return string
     */
    public function getQuantityShipped();

    /**
     * @param string $quantityShipped
     */
    public function setQuantityShipped($quantityShipped);

    /**
     * @return string
     */
    public function getPointsGranted();

    /**
     * @param string $pointsGranted
     */
    public function setPointsGranted($pointsGranted);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getItemPrice();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $itemPrice
     */
    public function setItemPrice($itemPrice);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingPrice();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingPrice
     */
    public function setShippingPrice($shippingPrice);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getGiftWrapPrice();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $giftWrapPrice
     */
    public function setGiftWrapPrice($giftWrapPrice);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getItemTax();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $itemTax
     */
    public function setItemTax($itemTax);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingTax();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingTax
     */
    public function setShippingTax($shippingTax);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getGiftWrapTax();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $giftWrapTax
     */
    public function setGiftWrapTax($giftWrapTax);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getShippingDiscount();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $shippingDiscount
     */
    public function setShippingDiscount($shippingDiscount);

    /**
     * @return \Springbot\Main\Api\Amazon\Order\Item\PriceInterface
     */
    public function getPromotionDiscount();

    /**
     * @param \Springbot\Main\Api\Amazon\Order\Item\PriceInterface $promotionDiscount
     */
    public function setPromotionDiscount($promotionDiscount);

    /**
     * @return string
     */
    public function getPromotionIds();

    /**
     * @param string $promotionIds
     */
    public function setPromotionIds($promotionIds);

    /**
     * @return string
     */
    public function getCodFee();

    /**
     * @param string $codFee
     */
    public function setCodFee($codFee);

    /**
     * @return string
     */
    public function getCodFeeDiscount();

    /**
     * @param string $codFeeDiscount
     */
    public function setCodFeeDiscount($codFeeDiscount);

    /**
     * @return string
     */
    public function getGiftMessageText();

    /**
     * @param string $giftMessageText
     */
    public function setGiftMessageText($giftMessageText);

    /**
     * @return string
     */
    public function getGiftWrapLevel();

    /**
     * @param string $giftWrapLevel
     */
    public function setGiftWrapLevel($giftWrapLevel);

    /**
     * @return string
     */
    public function getInvoiceData();

    /**
     * @param string $invoiceData
     */
    public function setInvoiceData($invoiceData);

    /**
     * @return string
     */
    public function getConditionNote();

    /**
     * @param string $conditionNote
     */
    public function setConditionNote($conditionNote);

    /**
     * @return string
     */
    public function getConditionId();

    /**
     * @param string $conditionId
     */
    public function setConditionId($conditionId);

    /**
     * @return string
     */
    public function getConditionSubtypeId();

    /**
     * @param string $conditionSubtypeId
     */
    public function setConditionSubtypeId($conditionSubtypeId);

    /**
     * @return string
     */
    public function getScheduledDeliveryStartDate();

    /**
     * @param string $scheduledDeliveryStartDate
     */
    public function setScheduledDeliveryStartDate($scheduledDeliveryStartDate);

    /**
     * @return string
     */
    public function getScheduledDeliveryEndDate();
    /**
     * @param string $scheduledDeliveryEndDate
     */
    public function setScheduledDeliveryEndDate($scheduledDeliveryEndDate);

    /**
     * @return string
     */
    public function getPriceDesignation();

    /**
     * @param string $priceDesignation
     */
    public function setPriceDesignation($priceDesignation);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt);
    /**
     * @return string
     */
    public function getStoreId();

    /**
     * @param string $storeId
     */
    public function setStoreId($storeId);

}
