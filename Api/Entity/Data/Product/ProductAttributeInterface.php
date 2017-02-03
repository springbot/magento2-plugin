<?php

namespace Springbot\Main\Api\Entity\Data\Product;

/**
 * Interface ProductAttributeInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Product
 */
interface ProductAttributeInterface
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
