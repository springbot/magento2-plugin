<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface GuestInterface
 *
 * Springbot "guests" are customers for which there is no customer record. Since they have no customer record, we
 * determine guests from order objects.
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface GuestInterface
{

    /**
     * @param $storeId
     * @param $orderId
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $createdAt
     * @param $updatedAt
     * @param $billingAddressId
     * @param $shippingAddressId
     * @return void
     */
    public function setValues(
        $storeId,
        $orderId,
        $firstname,
        $lastname,
        $email,
        $createdAt,
        $updatedAt,
        $billingAddressId,
        $shippingAddressId
    );

    /**
     * @return int
     */
    public function getGuestId();

    /**
     * @return int
     */
    public function getOrderId();

    /**
     * @return string
     */
    public function getFirstname();

    /**
     * @return string
     */
    public function getLastname();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Customer\AddressInterface
     */
    public function getBillingAddress();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Customer\AddressInterface
     */
    public function getShippingAddress();
}
