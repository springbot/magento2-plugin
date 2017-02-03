<?php

namespace Springbot\Main\Model\Api\Entity\Data\Product;

use Springbot\Main\Api\Entity\Data\Product\ProductAttributeInterface;

/**
 * Class ProductAttribute
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Product
 */
class ProductAttribute implements ProductAttributeInterface
{

    public $name;
    public $value;

    /**
     * ProductAttribute constructor.
     *
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
