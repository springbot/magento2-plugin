<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class StoreHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class StoreHandler extends AbstractHandler
{
    const api_path = 'stores';

    /**
     * @param int $storeId
     * @param int $id
     */
    public function handle($storeId, $id)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $id]);
    }

    /**
     * @param int $storeId
     * @param int $id
     */
    public function handleDelete($storeId, $id)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $id]);
    }
}
