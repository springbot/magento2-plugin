<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CartInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface CartInterface extends \Magento\Quote\Api\Data\CartInterface
{
    /**
     * @return array
     */
    public function getItems();

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @return string
     */
    public function getConvertedAt();

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @return string
     */
    public function getCustomerPrefix();

    /**
     * @return string
     */
    public function getCustomerFirstname();

    /**
     * @return string
     */
    public function getCustomerLastname();

    /**
     * @return string
     */
    public function getCustomerMiddlename();

    /**
     * @return string
     */
    public function getCustomerSuffix();

    /**
     * @return string
     */
    public function getCheckoutMethod();

    /**
     * @return string
     */
    public function getRemoteIp();


    /**
     * @return string
     */
    public function getCartUserAgent();
}
