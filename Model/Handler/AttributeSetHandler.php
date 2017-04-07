<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class AttributeSetHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class AttributeSetHandler extends AbstractHandler
{
    const api_path = 'attribute-sets';

    /**
     * @param int $storeId
     * @param int $attributeSetId
     */
    public function handle($storeId, $attributeSetId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $attributeSetId]);
    }

    /**
     * @param int $storeId
     * @param int $attributeSetId
     */
    public function handleDelete($storeId, $attributeSetId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $attributeSetId]);
    }
}
