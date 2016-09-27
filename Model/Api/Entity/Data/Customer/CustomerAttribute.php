<?php

namespace Springbot\Main\Model\Api\Entity\Data\Customer;

use Springbot\Main\Api\Entity\Data\Customer\CustomerAttributeInterface;

/**
 * Class CustomerAttribute
 * @package Springbot\Main\Model\Api\Entity\Data\Customer
 */
class CustomerAttribute implements CustomerAttributeInterface
{

    public $name;
    public $value;

    /**
     * CustomerAttribute constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

}
