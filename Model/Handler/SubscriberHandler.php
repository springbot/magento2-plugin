<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\SalesRule\Model\Rule as MagentoRule;

/**
 * Class SubscriberHandler
 * @package Springbot\Main\Model\Handler
 */
class SubscriberHandler extends Handler
{
    const API_PATH = 'subscribers';

    /**
     * @param $storeId
     * @param $subscriberId
     * @throws \Exception
     */
    public function handle($storeId, $subscriberId)
    {
        $rule = $this->objectManager->get('Springbot\Main\Api\Entity\Data\SubscriberInterface')->load($subscriberId);
        /* @var \Springbot\Main\Model\Entity\Data\Rule $rule */
        $data = $rule->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    /**
     * @param $storeId
     * @param $subscriberId
     */
    public function handleDelete($storeId, $subscriberId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $subscriberId]);
    }
}
