<?php

namespace Springbot\Main\Api\Amazon\Order;

/**
 * Interface AddressInterface
 * @package Springbot\Main\Api\Amazon\Order
 */
interface AddressInterface
{

    /**
     * @return mixed
     */
    public function getCity();

    /**
     * @param mixed $city
     */
    public function setCity($city);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getPhone();

    /**
     * @param mixed $phone
     */
    public function setPhone($phone);

    /**
     * @return mixed
     */
    public function getPostalCode();

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode);

    /**
     * @return mixed
     */
    public function getCountryCode();

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode);

    /**
     * @return mixed
     */
    public function getAddressLine1();

    /**
     * @param mixed $addressLine1
     */
    public function setAddressLine1($addressLine1);

    /**
     * @return mixed
     */
    public function getAddressLine2();

    /**
     * @param mixed $addressLine2
     */
    public function setAddressLine2($addressLine2);

    /**
     * @return mixed
     */
    public function getStateOrRegion();

    /**
     * @param mixed $stateOrRegion
     */
    public function setStateOrRegion($stateOrRegion);

    /**
     * @return array
     */
    public function toArray();

}
