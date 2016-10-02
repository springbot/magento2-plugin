<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class StoreHandler
 * @package Springbot\Main\Model\Handler
 */
class StoreHandler extends AbstractHandler
{
    const API_PATH = 'stores';

    /**
     * @param int $storeId
     * @param int $id
     */
    public function handle($storeId, $id)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $id]);
    }

    /**
     * @param int $storeId
     * @param int $id
     */
    public function handleDelete($storeId, $id)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $id]);
    }
}
