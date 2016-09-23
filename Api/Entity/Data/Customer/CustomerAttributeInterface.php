<?php

namespace Springbot\Main\Api\Entity\Data\Customer;

/**
 * Interface CustomerAttributeInterface
 * @package Springbot\Main\Api\Entity\Data\Customer
 */
interface CustomerAttributeInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();

}
