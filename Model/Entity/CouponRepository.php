<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\CouponRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 *  CouponRepository
 * @package Springbot\Main\Api
 */
class CouponRepository extends AbstractRepository implements CouponRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $array = $collection->toArray();
        return $array['items'];
    }

    public function getFromId($storeId, $couponId)
    {
        return $this->getSpringbotModel()->load($couponId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Coupon');
    }


}
