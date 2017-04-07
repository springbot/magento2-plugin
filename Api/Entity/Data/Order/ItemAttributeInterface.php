<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * Interface ItemInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface ItemAttributeInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return null
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $value
     * @return null
     */
    public function setValue($value);
}
