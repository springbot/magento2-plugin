<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class CustomerHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class CustomerHandler extends AbstractHandler
{
    const api_path = 'customers';

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handle($storeId, $customerId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $customerId]);
    }

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handleDelete($storeId, $customerId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $customerId]);
    }
}
