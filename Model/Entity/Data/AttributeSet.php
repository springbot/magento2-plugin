<?php

namespace Springbot\Main\Model\Entity\Data;

use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;
use Springbot\Main\Api\Entity\Data\AttributeSetInterface;

/**
 * Class AttributeSet
 * @package Springbot\Main\Model\Entity\Data
 */
class AttributeSet extends MagentoAttributeSet implements AttributeSetInterface
{

    public function getAttributes()
    {
        $attributeCollection = ObjectManager::getInstance()->create(AttributeCollection::class);
        /* @var AttributeCollection $attributeCollection */
        $attributeCollection->setAttributeSetFilter($this->getId());
        $attributes = $attributeCollection->toArray();
        return $attributes['items'];
    }
}
