<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;

/**
 * Class CartHandler
 * @package Springbot\Main\Model\Handler
 */
class CartHandler extends Handler
{
    const API_PATH = 'carts';

    /**
     * @param $storeId
     * @param $cartId
     * @throws \Exception
     */
    public function handle($storeId, $cartId)
    {
        $cart = $this->objectManager->get('Springbot\Main\Api\Entity\Data\CartInterface')->load($cartId);
        /* @var \Springbot\Main\Model\Entity\Data\Cart $cart */
        $data = $cart->toArray();

        foreach ($cart->getAllVisibleItems() as $item) {
            $data['items'][] = $item->toArray();
        }
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $cartId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $cartId]);
    }
}
