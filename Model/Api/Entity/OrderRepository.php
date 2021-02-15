<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\OrderRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\OrderFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;

/**
 *  OrderRepository
 *
 * @package Springbot\Main\Api
 */
class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    /* @var OrderFactory $orderFactory */
    protected $orderFactory;

    /* @var \Springbot\Main\Helper\Order $orderBuilder */
    protected $orderBuilder;

    /**
     * OrderRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http                $request
     * @param \Magento\Framework\App\ResourceConnection          $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\OrderFactory $factory
     * @param \Springbot\Main\Helper\Order                       $orderBuilder
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        OrderFactory $factory,
        \Springbot\Main\Helper\Order $orderBuilder
    ) {

        $this->orderBuilder = $orderBuilder;
        $this->orderFactory = $factory;
        parent::__construct($request, $resourceConnection);
    }

    /**
     * @param int $storeId
     * @return string[]
     */
    public function getList($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('sales_order')])
            ->where('store_id = ?', $storeId);
        $this->filterResults($select);

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createOrder($storeId, $row);
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
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('sales_order')])
            ->where('entity_id = ?', $orderId);

        foreach ($conn->fetchAll($select) as $row) {
            return $this->createOrder($storeId, $row);
        }
    }

    private function createOrder($storeId, $row)
    {
        $order = $this->orderFactory->create();
        $order->setValues(
            $storeId,
            $row['increment_id'],
            $row['entity_id'],
            $row['customer_email'],
            $row['quote_id'],
            $row['customer_id'],
            $row['grand_total'],
            $row['remote_ip'],
            $row['status'],
            $row['state'],
            $row['customer_is_guest'],
            $row['created_at'],
            $row['discount_amount'],
            $row['total_paid'],
            $row['shipping_description'],
            $row['shipping_amount'],
            $row['coupon_code'],
            $row['order_currency_code'],
            $row['base_tax_amount']
        );
        return $order;
    }
}
