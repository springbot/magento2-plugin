<?php

namespace Springbot\Main\Api\Entity\Data\AttributeSet;

/**
 * Interface AttributeSetAttributeInterface
 *
 * @package Springbot\Main\Api\Entity\Data\AttributeSet
 */
interface AttributeSetAttributeInterface
{

    /**
     * AttributeSetAttribute constructor.
     *
     * @param  int    $id
     * @param  string $label
     * @param  string $code
     * @param  array  $options
     * @return void
     */
    public function setValues($id, $label, $code, $options = []);

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
     * @return string[]
     */
    public function getOptions();
}
