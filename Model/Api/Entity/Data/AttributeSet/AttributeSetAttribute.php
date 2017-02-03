<?php

namespace Springbot\Main\Model\Api\Entity\Data\AttributeSet;

use Springbot\Main\Api\Entity\Data\AttributeSet\AttributeSetAttributeInterface;

/**
 * Class AttributeSetAttribute
 *
 * @package Springbot\Main\Model\Api\Entity\Data\AttributeSet
 */
class AttributeSetAttribute implements AttributeSetAttributeInterface
{

    public $id;
    public $label;
    public $code;
    public $options;

    /**
     * AttributeSetAttribute constructor.
     *
     * @param int    $id
     * @param string $label
     * @param string $code
     * @param array  $options
     */
    public function setValues($id, $label, $code, $options = [])
    {
        $this->id = $id;
        $this->label = $label;
        $this->code = $code;
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }
}
