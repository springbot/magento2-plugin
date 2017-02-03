<?php

namespace Springbot\Main\Api\Entity\Data\Customer;

/**
 * Interface ItemInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Cart
 */
interface AddressInterface
{

    /**
     * @return int
     */
    public function getAddressId();

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getCompany();

    /**
     * @return string
     */
    public function getCountryId();

    /**
     * @return string
     */
    public function getFax();

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
    public function getMiddlename();

    /**
     * @return string
     */
    public function getPostcode();

    /**
     * @return string
     */
    public function getPrefix();

    /**
     * @return string
     */
    public function getRegion();

    /**
     * @return string
     */
    public function getStreet();

    /**
     * @return string
     */
    public function getSuffix();

    /**
     * @return string
     */
    public function getTelephone();
}
