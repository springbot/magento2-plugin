<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Springbot\Main\Model\Entity\Data\AttributeSet;
use Springbot\Main\Model\Handler;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;

/**
 * Class AttributeSetHandler
 * @package Springbot\Main\Model\Handler
 */
class AttributeSetHandler extends Handler
{
    const API_PATH = 'attribute-sets';

    /**
     * @param $storeId
     * @param $attributeSetId
     * @throws \Exception
     */
    public function handle($storeId, $attributeSetId)
    {
        $attributeSet = $this->objectManager->get('Springbot\Main\Api\Entity\Data\AttributeSetInterface')->load($attributeSetId);
        /* @var \Springbot\Main\Model\Entity\Data\AttributeSet $attributeSet */
        $data = $attributeSet->toArray();
        $data['attributes'] = $attributeSet->getAttributes();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
        throw new \Exception('test');
    }

    /**
     * @param $storeId
     * @param $attributeSetId
     */
    public function handleDelete($storeId, $attributeSetId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $attributeSetId]);
    }
}
