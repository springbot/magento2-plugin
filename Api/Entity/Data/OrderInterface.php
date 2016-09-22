<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface OrderInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface OrderInterface
{
    /**
     * @return int
     */
    public function getIncrementId();

    /**
     * @return int
     */
    public function getEntityId();

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
     * @return array
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
     * @return \Magento\Sales\Api\Data\ShipmentInterface|null
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


}
