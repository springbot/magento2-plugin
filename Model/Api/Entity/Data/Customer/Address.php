<?php

namespace Springbot\Main\Model\Api\Entity\Data\Customer;

use Springbot\Main\Api\Entity\Data\Customer\AddressInterface;

/**
 * Class Address
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Customer
 */
class Address implements AddressInterface
{

    public $addressId;
    public $createdAt;
    public $updatedAt;
    public $isActive;
    public $city;
    public $company;
    public $countryId;
    public $fax;
    public $firstname;
    public $lastname;
    public $middlename;
    public $postcode;
    public $prefix;
    public $region;
    public $street;
    public $suffix;
    public $telephone;
    public $attributes;
    public $customerId;

    public function setValues(
        $addressId,
        $isActive,
        $city,
        $company,
        $countryId,
        $fax,
        $firstname,
        $lastname,
        $middlename,
        $postcode,
        $prefix,
        $region,
        $street,
        $suffix,
        $telephone
    ) {
        $this->addressId = $addressId;
        $this->isActive = $isActive;
        $this->city = $city;
        $this->company = $company;
        $this->countryId = $countryId;
        $this->fax = $fax;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->middlename = $middlename;
        $this->postcode = $postcode;
        $this->prefix = $prefix;
        $this->region = $region;
        $this->street = $street;
        $this->suffix = $suffix;
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}
