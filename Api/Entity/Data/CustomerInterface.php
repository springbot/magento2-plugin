<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CustomerInterface
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface CustomerInterface
{

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return int
     */
    public function getGroupName();

    /**
     * @return int
     */
    public function getAttributeSetId();

    /**
     * @return bool
     */
    public function getHasPurchase();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Customer\CustomerAttributeInterface[]
     */
    public function getCustomerAttributes();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Customer\AddressInterface
     */
    public function getShippingAddress();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Customer\AddressInterface
     */
    public function getBillingAddress();
}
