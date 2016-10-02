<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Springbot\Main\Api\Entity\Data\OrderInterface;

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
    public $shipments;
    public $couponCode;
    public $orderCurrencyCode;
    public $baseTaxAmount;
    public $cartUserAgent;
    public $orderUserAgent;

    protected $objectManager;
    protected $productRepository;
    protected $connectionResource;

    /**
     * Order constructor.
     * @param \Magento\Framework\App\ResourceConnection $connectionResource
     * @param \Magento\Framework\App\ObjectManager $objectManager
     * @param \Springbot\Main\Api\Entity\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ResourceConnection $connectionResource,
        ObjectManager $objectManager,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->objectManager = $objectManager;
        $this->productRepository = $productRepository;
        $this->connectionResource = $connectionResource;
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
     * @return null
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
        return $this->shipments;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        $conn = $this->connectionResource->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('sales_order_payment')])
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
        $conn = $this->connectionResource->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('springbot_order_redirect')])
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
        $conn = $this->connectionResource->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('sales_order_item')])
            ->where('order_id = ?', $this->orderId);

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $item = $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Order\Item');
            /* @var \Springbot\Main\Model\Api\Entity\Data\Order\Item $item */

            $product = $this->productRepository->getFromId($this->storeId, $row['product_id']);
            if ($parentProductId =  $row['parent_item_id']) {
                /* @var \Springbot\Main\Model\Api\Entity\ProductRepository $productRepo */
                $product = $this->productRepository->getFromId($this->storeId, $parentProductId);
                $parentSku = $product->getSku();
            }
            else {
                $parentSku = $row['sku'];
            }

            /* @var \Springbot\Main\Model\Api\Entity\Data\Product $product */
            $item->setValues(
                $parentSku,
                $row['sku'],
                $row['qty_ordered'],
                $product->getDefaultUrl(),
                $product->getImageUrl(),
                $row['weight'],
                $row['name'],
                $product->getDescription(),
                $row['price'],
                $row['product_id'],
                $row['product_type'],
                $product->getCategoryIds(),
                $product->getAllCategoryIds(),
                $product->getCustomAttributeSetId(),
                $product->getProductAttributes()
            );
            $ret[] = $item;
        }
        return $ret;
    }


    public function getCartUserAgent()
    {
        return $this->fetchTrackable('quote_id', $this->quoteId, 'cart_user_agent');
    }

    public function getOrderUserAgent()
    {
        return $this->fetchTrackable('order_id', $this->orderId, 'order_user_agent');
    }

    private function fetchTrackable($column, $value, $type)
    {
        $conn = $this->connectionResource->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('springbot_trackable')])
            ->where($column . ' = ?', $value)
            ->where('type = ?', $type)
            ->order('id', 'DESC');
        foreach ($conn->fetchAll($select) as $row) {
            return $row['value'];
        }
    }

}
