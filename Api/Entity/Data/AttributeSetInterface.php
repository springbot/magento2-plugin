<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface AttributeSetInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface AttributeSetInterface
{

    /**
     * @return int
     */
    public function getAttributeSetId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return \Springbot\Main\Api\Entity\Data\AttributeSet\AttributeSetAttributeInterface[]
     */
    public function getAttributes();

}