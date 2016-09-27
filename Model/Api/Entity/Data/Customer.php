<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Customer\Model\Customer as MagentoCustomer;
use Springbot\Main\Api\Entity\Data\CustomerInterface;
use Springbot\Main\Model\Api\Entity\Data\Customer\Address;
use Springbot\Main\Model\Api\Entity\Data\Customer\CustomerAttribute;

/**
 * Class Customer
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Customer extends MagentoCustomer implements CustomerInterface
{
    public function getCustomerId()
    {
        return parent::getEntityId();
    }

    public function getFirstName()
    {
        return parent::getFirstname();
    }

    public function getLastName()
    {
        return parent::getLastname();
    }

    public function getEmail()
    {
        return parent::getEmail();
    }

    public function getAttributeSetId()
    {
        return parent::getAttributeSetId();
    }

    public function getHasPurchase()
    {
        return parent::hasPurchase();
    }

    public function getCustomerAttributes()
    {
        $attributes = [];
        foreach ($this->getAttributes() as $attribute) {
            $attributes[] = new CustomerAttribute($attribute->getAttributeCode(), $attribute->getValue());
        }
        return $attributes;
    }

    public function getShippingAddress()
    {
        if ($address = $this->getDefaultShippingAddress()) {
            return new Address(
                $address->getEntityid(),
                $address->getIncrementId(),
                $address->getCreatedAt(),
                $address->getUpdatedAt(),
                $address->getIsActive(),
                $address->getCity(),
                $address->getCompany(),
                $address->getCountryId(),
                $address->getFax(),
                $address->getFirstname(),
                $address->getLastname(),
                $address->getMiddlename(),
                $address->getPostCode(),
                $address->getPrefix(),
                $address->getRegion(),
                $address->getStreet(),
                $address->getSuffix(),
                $address->getTelephone()
            );
        }
        else {
           return null;
        }
    }

    public function getBillingAddress()
    {
        if ($address = $this->getDefaultBillingAddress()) {
            return new Address(
                $address->getEntityid(),
                $address->getIncrementId(),
                $address->getCreatedAt(),
                $address->getUpdatedAt(),
                $address->getIsActive(),
                $address->getCity(),
                $address->getCompany(),
                $address->getCountryId(),
                $address->getFax(),
                $address->getFirstname(),
                $address->getLastname(),
                $address->getMiddlename(),
                $address->getPostCode(),
                $address->getPrefix(),
                $address->getRegion(),
                $address->getStreet(),
                $address->getSuffix(),
                $address->getTelephone()
            );
        }
        else {
            return null;
        }
    }

}
