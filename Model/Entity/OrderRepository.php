<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\OrderRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 *  OrderRepository
 * @package Springbot\Main\Api
 */
class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection as $order) {
            $ret = $this->getFromId($storeId, $order->getEntityId());
        }
        return $ret;
    }

    public function getFromId($storeId, $orderId)
    {
        return $this->getSpringbotModel()->load($orderId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Order');
    }
}
