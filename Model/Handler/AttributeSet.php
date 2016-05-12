<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Springbot\Main\Model\Handler;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;

/**
 * Class AttributeSet
 *
 * @package Springbot\Main\Model\Handler
 */
class AttributeSet extends Handler
{
    const API_PATH = 'attribute_sets';
    const ENTITIES_NAME = 'attribute_sets';

    /**
     * @param $storeId
     * @param $attributeSetId
     * @throws \Exception
     */
    public function handle($storeId, $attributeSetId)
    {
        $attributeSet = $this->objectManager->get('Magento\Eav\Model\Entity\Attribute\Set')->load($attributeSetId);
        /* @var MagentoAttributeSet $attributeSet */
        $array = $attributeSet->toArray();
        $attributeCollection = $this->objectManager->create(AttributeCollection::class);
        /* @var AttributeCollection $attributeCollection */
        $attributeCollection->setAttributeSetFilter($attributeSetId);
        $attributesArray = $attributeCollection->load()->getItems();

        $attributeSetItems = [];
        foreach ($attributesArray as $attribute) {
            $attributeSetItems[] = $attribute->toArray();
        }
        $array['items'] = $attributeSetItems;

        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    /**
     * @param $storeId
     * @param $attributeSetId
     */
    public function handleDelete($storeId, $attributeSetId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $attributeSetId]);
    }
}
