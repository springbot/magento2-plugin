<?php

namespace Springbot\Main\Model\Api\Amazon\Order;

use Springbot\Main\Api\Amazon\Order\AddressInterface;

/**
 * Class Address
 * @package Springbot\Main\Model\Api\Amazon\Order
 */
class Address implements AddressInterface
{

    private $city;
    private $name;
    private $phone;
    private $postalCode;
    private $countryCode;
    private $addressLine1;
    private $addressLine2;
    private $stateOrRegion;
    private $stateToCode = [
        'ALABAMA'        => 'AL',
        'ALASKA'         => 'AK',
        'ARIZONA'        => 'AZ',
        'ARKANSAS'       => 'AR',
        'CALIFORNIA'     => 'CA',
        'COLORADO'       => 'CO',
        'CONNECTICUT'    => 'CT',
        'DELAWARE'       => 'DE',
        'FLORIDA'        => 'FL',
        'GEORGIA'        => 'GA',
        'HAWAII'         => 'HI',
        'IDAHO'          => 'ID',
        'ILLINOIS'       => 'IL',
        'INDIANA'        => 'IN',
        'IOWA'           => 'IA',
        'KANSAS'         => 'KS',
        'KENTUCKY'       => 'KY',
        'LOUISIANA'      => 'LA',
        'MAINE'          => 'ME',
        'MARYLAND'       => 'MD',
        'MASSACHUSETTS'  => 'MA',
        'MICHIGAN'       => 'MI',
        'MINNESOTA'      => 'MN',
        'MISSISSIPPI'    => 'MS',
        'MISSOURI'       => 'MO',
        'MONTANA'        => 'MT',
        'NEBRASKA'       => 'NE',
        'NEVADA'         => 'NV',
        'NEW HAMPSHIRE'  => 'NH',
        'NEW JERSEY'     => 'NJ',
        'NEW MEXICO'     => 'NM',
        'NEW YORK'       => 'NY',
        'NORTH CAROLINA' => 'NC',
        'NORTH DAKOTA'   => 'ND',
        'OHIO'           => 'OH',
        'OKLAHOMA'       => 'OK',
        'OREGON'         => 'OR',
        'PENNSYLVANIA'   => 'PA',
        'RHODE ISLAND'   => 'RI',
        'SOUTH CAROLINA' => 'SC',
        'SOUTH DAKOTA'   => 'SD',
        'TENNESSEE'      => 'TN',
        'TEXAS'          => 'TX',
        'UTAH'           => 'UT',
        'VERMONT'        => 'VT',
        'VIRGINIA'       => 'VA',
        'WASHINGTON'     => 'WA',
        'WEST VIRGINIA'  => 'WV',
        'WISCONSIN'      => 'WI',
        'WYOMING'        => 'WY'
    ];

    /**
     * Convert an amazon address into the format expected by Magento
     *
     * @return array
     */
    public function toArray()
    {
        $ret =  [
            "firstname"  => $this->getFirstName(),
            "lastname"   => $this->getLastName(),
            "telephone"  => $this->getPhone(),
            "city"       => $this->getCity(),
            "region"     => $this->getRegionCode(),
            "postcode"   => $this->getPostalCode(),
            "country_id" => $this->getCountryCode(),
            "street"     => $this->getStreet()
        ];
        return $ret;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param mixed $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return mixed
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param mixed $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return mixed
     */
    public function getStateOrRegion()
    {
        return $this->stateOrRegion;
    }

    /**
     * @param mixed $stateOrRegion
     */
    public function setStateOrRegion($stateOrRegion)
    {
        $this->stateOrRegion = $stateOrRegion;
    }

    /**
     * @return string
     */
    private function getFirstName()
    {
        $parts = explode(' ' , $this->getName());
        array_pop($parts);
        return implode(' ', $parts);
    }

    /**
     * @return string
     */
    private function getLastName()
    {
        $parts = explode(' ' , $this->getName());
        return end($parts);
    }

    /**
     * @return string
     */
    private function getStreet()
    {
        $ret = $this->getAddressLine1();
        if ($this->getAddressLine2()) {
            $ret .= "\n" . $this->getAddressLine2();
        }
        return $ret;
    }

    /**
     * @return mixed|string
     */
    private function getRegionCode()
    {
        $upper = strtoupper($this->getStateOrRegion());
        if (isset($this->stateToCode[$upper])) {
            return $this->stateToCode[$upper];
        }
        else {
            return $upper;
        }
    }

}