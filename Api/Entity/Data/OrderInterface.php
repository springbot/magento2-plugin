<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface OrderInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface OrderInterface
{
    /**
     * @return string
     */
    public function getCustomerEmail();

    /**
     * @return string
     */
    public function getGrandTotal();

    /**
     * @return int
     */
    public function getQuoteId();

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
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getDiscountAmount();

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @return string
     */
    public function getRedirectMongoId();

    /**
     * @return array
     */
    public function getRedirectMongoIds();

    /**
     * @return string
     */
    public function getTotalPaid();

    /**
     * @return string
     */
    public function getShippingMethod();


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
     * @return int
     */
    public function getCustomerId();

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
