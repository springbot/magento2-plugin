<?php

namespace Springbot\Main\Model\Entity\Data;

use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;
use Springbot\Main\Api\Entity\Data\AttributeSetInterface;
use Springbot\Main\Model\Entity\Data\AttributeSet\AttributeSetAttribute;

/**
 * Class AttributeSet
 * @package Springbot\Main\Model\Entity\Data
 */
class AttributeSet extends MagentoAttributeSet implements AttributeSetInterface
{
    /**
     * @return int
     */
    public function getAttributeSetId()
    {
        return parent::getId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getAttributeSetName();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return parent::getEntityTypeId();
    }

    /**
     * @return \Springbot\Main\Api\Entity\Data\AttributeSet\AttributeSetAttributeInterface[]
     */
    public function getAttributes()
    {
        $om = ObjectManager::getInstance();
        $attributeCollection = $om->create(AttributeCollection::class);
        /* @var AttributeCollection $attributeCollection */
        $attributeCollection->setAttributeSetFilter($this->getId());
        $attributes = [];
        foreach ($attributeCollection as $attribute) {
            $options = [];
            foreach ($attribute->getOptions() as $option) {
                $options[] = $option->getLabel();
            }
            if (!$options) {
                $options = null;
            }
            $attributes[] = new AttributeSetAttribute(
                $attribute->getId(),
                $attribute->getFrontendLabel(),
                $attribute->getAttributeCode(),
                $options
            );
        }
        return $attributes;
    }
}
