<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Springbot\Main\Model\Handler;

/**
 * Class AttributeSetHandler
 * @package Springbot\Main\Model\Handler
 */
class AttributeSetHandler extends Handler
{
    const API_PATH = 'attribute-sets';

    /**
     * @param int $storeId
     * @param int $attributeSetId
     */
    public function handle($storeId, $attributeSetId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $attributeSetId]);
    }

    /**
     * @param int $storeId
     * @param int $attributeSetId
     */
    public function handleDelete($storeId, $attributeSetId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $attributeSetId]);
    }
}
