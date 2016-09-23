<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\OrderRepositoryInterface;
use Springbot\Main\Helper\Order;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 *  OrderRepository
 * @package Springbot\Main\Api
 */
class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    private $orderBuilder;

    /**
     * @param \Springbot\Main\Helper\Order $orderBuilder
     */
    public function __construct(
        \Springbot\Main\Helper\Order $orderBuilder,
        \Magento\Framework\App\Request\Http $http
    ) {
        $this->orderBuilder = $orderBuilder;
        parent::__construct($http);
    }

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection as $order) {
            $ret[] = $this->getFromId($storeId, $order->getEntityId());
        }
        return $ret;
    }

    public function getFromId($storeId, $orderId)
    {
        return $this->getSpringbotModel()->load($orderId);
    }

    public function create($storeId, $customer, $address, $quote, $items)
    {
        return $this->orderBuilder->buildOrder($storeId, $customer, $address, $quote, $items);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Order');
    }
}
