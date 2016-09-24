<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\Entity\OrderRepositoryInterface;

/**
 *  OrderRepository
 * @package Springbot\Main\Api
 */
class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{

    /**
     * @param int $storeId
     * @return array
     */
    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $collection->addFieldToFilter('store_id', $storeId);
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection as $order) {
            $ret[] = $this->getFromId($storeId, $order->getEntityId());
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $orderId
     * @return $this
     */
    public function getFromId($storeId, $orderId)
    {
        return $this->getSpringbotModel()->load($orderId);
    }

    /**
     * @return mixed
     */
    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Order');
    }
}
