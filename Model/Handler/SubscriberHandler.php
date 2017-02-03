<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class SubscriberHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class SubscriberHandler extends AbstractHandler
{
    const api_path = 'subscribers';

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handle($storeId, $subscriberId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => $subscriberId]);
    }

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handleDelete($storeId, $subscriberId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => $subscriberId]);
    }
}
