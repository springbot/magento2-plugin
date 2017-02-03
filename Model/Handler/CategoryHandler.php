<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class CategoryHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class CategoryHandler extends AbstractHandler
{
    const api_path = 'categories';

    /**
     * @param int $storeId
     * @param int $categoryId
     */
    public function handle($storeId, $categoryId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $categoryId]);
    }

    /**
     * @param int $storeId
     * @param int $categoryId
     */
    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $categoryId]);
    }
}
