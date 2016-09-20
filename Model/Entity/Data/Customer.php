<?php

namespace Springbot\Main\Model\Entity\Data;

/**
 *  Customer
 * @package Springbot\Main\Api\Data
 */
class Customer extends \Magento\Customer\Model\Customer
{

    public function getShippingAddress()
    {
        return $this->getDefaultShippingAddress()->toArray();
    }

    public function getBillingAddress()
    {
        return $this->getDefaultBillingAddress()->toArray();
    }

}
