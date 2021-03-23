<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\Data\OrderInterface;
use Springbot\Main\Model\Api\Entity\Data\Order\ItemFactory;
use Springbot\Main\Model\Api\Entity\Data\Order\ShipmentFactory;

/**
 * Class Order
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Order implements OrderInterface
{
    public $storeId;
    public $incrementId;
    public $orderId;
    public $customerEmail;
    public $quoteId;
    public $redirectMongoId;
    public $redirectMongoIds;
    public $customerId;
    public $grandTotal;
    public $remoteIp;
    public $status;
    public $state;
    public $customerIsGuest;
    public $createdAt;
    public $discountAmount;
    public $totalPaid;
    public $shippingMethod;
    public $shippingAmount;
    public $couponCode;
    public $orderCurrencyCode;
    public $baseTaxAmount;
    public $cartUserAgent;
    public $orderUserAgent;

    private $resourceConnection;
    private $itemFactory;
    private $shipmentFactory;

    public function __construct(
        ResourceConnection $productRepository,
        ItemFactory $factory,
        ShipmentFactory $shipmentFactory
    ) {
        $this->resourceConnection = $productRepository;
        $this->itemFactory = $factory;
        $this->shipmentFactory = $shipmentFactory;
    }

    /**
     * @param $storeId
     * @param $incrementId
     * @param $orderId
     * @param $customerEmail
     * @param $quoteId
     * @param $customerId
     * @param $grandTotal
     * @param $remoteIp
     * @param $status
     * @param $state
     * @param $customerIsGuest
     * @param $createdAt
     * @param $discountAmount
     * @param $totalPaid
     * @param $shippingMethod
     * @param $shippingAmount
     * @param $couponCode
     * @param $orderCurrencyCode
     * @param $baseTaxAmount
     * @return void
     */
    public function setValues(
        $storeId,
        $incrementId,
        $orderId,
        $customerEmail,
        $quoteId,
        $customerId,
        $grandTotal,
        $remoteIp,
        $status,
        $state,
        $customerIsGuest,
        $createdAt,
        $discountAmount,
        $totalPaid,
        $shippingMethod,
        $shippingAmount,
        $couponCode,
        $orderCurrencyCode,
        $baseTaxAmount
    ) {
        $this->storeId = $storeId;
        $this->incrementId = $incrementId;
        $this->orderId = $orderId;
        $this->customerEmail = $customerEmail;
        $this->quoteId = $quoteId;
        $this->customerId = $customerId;
        $this->grandTotal = $grandTotal;
        $this->remoteIp = $remoteIp;
        $this->status = $status;
        $this->state = $state;
        $this->customerIsGuest = $customerIsGuest;
        $this->createdAt = $createdAt;
        $this->discountAmount = $discountAmount;
        $this->totalPaid = $totalPaid;
        $this->shippingMethod = $shippingMethod;
        $this->shippingAmount = $shippingAmount;
        $this->couponCode = $couponCode;
        $this->orderCurrencyCode = $orderCurrencyCode;
        $this->baseTaxAmount = $baseTaxAmount;
    }

    /**
     * @return mixed
     */
    public function getIncrementId()
    {
        return $this->incrementId;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @return mixed
     */
    public function getQuoteId()
    {
        return $this->quoteId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @return mixed
     */
    public function getGrandTotal()
    {
        return $this->grandTotal;
    }

    /**
     * @return mixed
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getCustomerIsGuest()
    {
        return $this->customerIsGuest;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @return mixed
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @return mixed
     */
    public function getShippingAmount()
    {
        return $this->shippingAmount;
    }

    /**
     * @return mixed
     */
    public function getShipments()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['ss' => $resource->getTableName('sales_shipment')])
            ->joinleft(
                ['sst' => $resource->getTableName('sales_shipment_track')],
                'ss.entity_id = sst.parent_id',
                ['sst.track_number', 'sst.carrier_code', 'sst.title']
            )
            ->joinleft(
                ['soa' => $resource->getTableName('sales_order_address')],
                'soa.entity_id = ss.shipping_address_id',
                ['soa.prefix', 'soa.firstname', 'soa.middlename', 'soa.lastname', 'soa.suffix']
            )
            ->where('ss.order_id = ?', $this->orderId);
        $shipments = [];
        foreach ($conn->fetchAll($select) as $row) {
            $shipToName = "{$row['prefix']} {$row['firstname']} {$row['middlename']} {$row['lastname']} {$row['suffix']}";
            $shipToName = trim(str_replace('  ', ' ', $shipToName));
            $shipment = $this->shipmentFactory->create();
            $shipment->setValues(
                $row['entity_id'],
                $row['track_number'],
                $row['carrier_code'],
                $row['title'],
                $shipToName,
                $row['shipment_status']
            );
            $shipments[] = $shipment;
        }
        return $shipments;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('sales_order_payment')])
            ->where('entity_id = ?', $this->orderId);
        foreach ($conn->fetchAll($select) as $payment) {
            return $payment['method'];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getCouponCode()
    {
        return $this->couponCode;
    }

    /**
     * @return mixed
     */
    public function getOrderCurrencyCode()
    {
        return $this->orderCurrencyCode;
    }

    /**
     * @return mixed
     */
    public function getBaseTaxAmount()
    {
        return $this->baseTaxAmount;
    }

    public function getRedirectMongoId()
    {
        $redirects = $this->getRedirectMongoIds();
        return end($redirects);
    }

    public function getRedirectMongoIds()
    {
        if (isset($this->redirectMongoIds)) {
            return $this->redirectMongoIds;
        }
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('springbot_order_redirect')])
            ->where('order_id = ?', $this->orderId)
            ->order('id', 'DESC');

        $redirectIds = [];
        foreach ($conn->fetchAll($select) as $row) {
            $redirectIds[] = $row['redirect_string'];
        }
        $this->redirectMongoIds = $redirectIds;
        return $this->redirectMongoIds;
    }

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemInterface[];
     */
    public function getItems()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['soi' => $resource->getTableName('sales_order_item')])
            ->joinLeft(
                ['soip' => $resource->getTableName('sales_order_item')],
                'soi.parent_item_id = soip.item_id',
                ['parent_product_id' => 'soip.product_id', 'parent_price' => 'soip.price']
            )
            ->joinLeft(
                ['pp' => $resource->getTableName('catalog_product_entity')],
                'pp.entity_id = soip.product_id',
                ['pp.sku AS parent_sku']
            )
            ->where('soi.order_id = ?', $this->orderId);

        $ret = [];

        $toRemove = [];

        foreach ($conn->fetchAll($select) as $row) {
            $item = $this->itemFactory->create();
            /* @var \Springbot\Main\Model\Api\Entity\Data\Order\Item $item */

            if (isset($row['parent_sku']) && $row['parent_sku']) {
                $parentSku = $row['parent_sku'];

                // Magento creates two items for parent/child products, but we only want one
                $toRemove[] = $row['parent_item_id'];
            } else {
                $parentSku = $row['sku'];
            }

            $price = $row['price'];
            if (isset($row['parent_price']) && ($row['parent_price'] !== null) && ($row['parent_price'] > 0)) {
                $price = $row['parent_price'];
            }

            $item->setValues(
                $this->storeId,
                $parentSku,
                $row['sku'],
                $row['qty_ordered'],
                $row['weight'],
                $row['name'],
                $price,
                $row['product_id'],
                $row['parent_product_id'],
                $row['product_type']
            );
            $ret[$row['item_id']] = $item;
        }

        // Remove the duplicate line items for parent/child items
        foreach ($toRemove as $itemIdToRemove) {
            unset($ret[$itemIdToRemove]);
        }

        return array_values($ret);
    }

    public function getCartUserAgent()
    {
        return "";
    }

    public function getOrderUserAgent()
    {
        return "";
    }
}
