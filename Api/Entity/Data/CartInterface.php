<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CartInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface CartInterface
{

    /**
     * @return \Springbot\Main\Api\Entity\Data\Cart\ItemInterface[]
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
    public function getUpdatedAt();

    /**
     * @return string
     */
    public function getCustomerEmail();

}
