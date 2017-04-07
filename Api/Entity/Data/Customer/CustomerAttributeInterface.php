<?php

namespace Springbot\Main\Api\Entity\Data\Customer;

/**
 * Interface CustomerAttributeInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Customer
 */
interface CustomerAttributeInterface
{


    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function setValues($name, $value);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();
}
