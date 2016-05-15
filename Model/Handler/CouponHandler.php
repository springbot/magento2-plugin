<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Category as MagentoCategory;

/**
 * Class CouponHandler
 * @package Springbot\Main\Model\Handler
 */
class CouponHandler extends Handler
{
    const API_PATH = 'categories';

    /**
     * @param $storeId
     * @param $couponId
     * @throws \Exception
     */
    public function handle($storeId, $couponId)
    {
        $coupon = $this->objectManager->get('Springbot\Main\Api\Entity\Data\CouponInterface')->load($couponId);
        /* @var \Springbot\Main\Model\Entity\Data\Coupon $coupon */
        $data = $coupon->toArray();
        $this->api->postEntities($storeId, self::API_PATH, [$data]);
    }

    public function handleDelete($storeId, $categoryId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, ['id' => $categoryId]);
    }
}
