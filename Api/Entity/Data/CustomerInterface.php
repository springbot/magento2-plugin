<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CustomerInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface CustomerInterface extends \Magento\Customer\Api\Data\CustomerInterface
{

    /**
     * @return array
     */
    public function getShippingAddress();

    /**
     * @return array
     */
    public function getBillingAddress();

}
