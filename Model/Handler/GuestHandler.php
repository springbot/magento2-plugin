<?php

namespace Springbot\Main\Model\Handler;

/**
 * Class GuestHandler
 *
 * @package Springbot\Main\Model\Handler
 */
class GuestrHandler extends AbstractHandler
{
    const api_path = 'guests';

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handle($storeId, $customerId)
    {
        $this->api->postEntities($storeId, self::api_path, ['id' => ($customerId + $this->scopeConfig->getValue('springbot/configuration/guest_offset'))]);
    }

    /**
     * @param int $storeId
     * @param int $customerId
     */
    public function handleDelete($storeId, $customerId)
    {
        $this->api->deleteEntity($storeId, self::api_path, ['id' => ($customerId + $this->scopeConfig->getValue('springbot/configuration/guest_offset'))]);
    }
}
