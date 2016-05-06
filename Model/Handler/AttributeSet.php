<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class AttributeSet extends Handler
{
    const API_PATH = 'attribute_sets';
    const ENTITIES_NAME = 'attribute_sets';

    public function handle($storeId, $attributeSetId)
    {

    }

    public function handleDelete($storeId, $attributeSetId)
    {

    }

    /**
     * @param MagentoAttributeSet $attributeSet
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoAttributeSet $attributeSet, $dataSource)
    {
        foreach ($attributeSet->getCustomAttributes() as $attribute) {

        }
        return [];
    }

}
