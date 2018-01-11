<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface OrderInterface
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface OrderInterface
{

    /**
     * @param $storeId
     * @param $incrementId
     * @param $orderId
     * @param $customerEmail
     * @param $quoteId
     * @param $customerId
     * @param $grandTotal
     * @param $remoteIp
     * @param $status
     * @param $state
     * @param $customerIsGuest
     * @param $createdAt
     * @param $discountAmount
     * @param $totalPaid
     * @param $shippingMethod
     * @param $shippingAmount
     * @param $couponCode
     * @param $orderCurrencyCode
     * @param $baseTaxAmount
     * @return null
     */
    public function setValues(
        $storeId,
        $incrementId,
        $orderId,
        $customerEmail,
        $quoteId,
        $customerId,
        $grandTotal,
        $remoteIp,
        $status,
        $state,
        $customerIsGuest,
        $createdAt,
        $discountAmount,
        $totalPaid,
        $shippingMethod,
        $shippingAmount,
        $couponCode,
        $orderCurrencyCode,
        $baseTaxAmount
    );

    /**
     * @return int
     */
    public function getIncrementId();

    /**
     * @return int
     */
    public function getOrderId();

    /**
     * @return string
     */
    public function getCustomerEmail();

    /**
     * @return int
     */
    public function getQuoteId();

    /**
     * @return string
     */
    public function getRedirectMongoId();

    /**
     * @return string[]
     */
    public function getRedirectMongoIds();

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @return string
     */
    public function getGrandTotal();

    /**
     * @return string
     */
    public function getRemoteIp();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getState();


    /**
     * @return bool
     */
    public function getCustomerIsGuest();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getDiscountAmount();

    /**
     * @return string
     */
    public function getTotalPaid();

    /**
     * @return string
     */
    public function getShippingMethod();

    /**
     * @return string
     */
    public function getShippingAmount();

    /**
     * Get all shipments
     *
     * @return \Springbot\Main\Api\Entity\Data\Order\ShipmentInterface[]
     */
    public function getShipments();

    /**
     * Gets order payment
     *
     * @return \Magento\Sales\Api\Data\OrderPaymentInterface|null
     */
    public function getPayment();

    /**
     * @return string
     */
    public function getCouponCode();

    /**
     * @return string
     */
    public function getOrderCurrencyCode();

    /**
     * @return string
     */
    public function getBaseTaxAmount();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemInterface[]
     */
    public function getItems();

    /**
     * @return string
     */
    public function getCartUserAgent();

    /**
     * @return string
     */
    public function getOrderUserAgent();
}
