<?php

namespace Springbot\Main\Api\Entity\Data\AttributeSet;

/**
 * Interface AttributeSetAttributeInterface
 * @package Springbot\Main\Api\Entity\Data\AttributeSet
 */
interface AttributeSetAttributeInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return array
     */
    public function getOptions();


}
