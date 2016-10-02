<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class SubscriberHandler
 * @package Springbot\Main\Model\Handler
 */
class SubscriberHandler extends AbstractHandler
{
    const API_PATH = 'subscribers';

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handle($storeId, $subscriberId)
    {
        $this->api->postEntities($storeId, self::API_PATH, ['id' => $subscriberId]);
    }

    /**
     * @param int $storeId
     * @param int $subscriberId
     */
    public function handleDelete($storeId, $subscriberId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $subscriberId]);
    }
}
