<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\CartInterface;
use Springbot\Main\Model\Api\Entity\Data\Cart\ItemFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Cart
 *
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Cart implements CartInterface
{

    public $storeId;
    public $cartId;
    public $convertedAt;
    public $customerId;
    public $customerPrefix;
    public $customerFirstname;
    public $customerLastname;
    public $customerMiddlename;
    public $customerSuffix;
    public $checkoutMethod;
    public $remoteIp;
    public $customerIsGuest;
    public $createdAt;
    public $updatedAt;
    public $customerEmail;

    private $resourceConnection;
    private $itemFactory;

    /**
     * Cart constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param ItemFactory        $itemFactory
     */
    public function __construct(ResourceConnection $resourceConnection, ItemFactory $itemFactory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->itemFactory = $itemFactory;
    }


    public function setValues(
        $storeId,
        $cartId,
        $convertedAt,
        $customerId,
        $customerPrefix,
        $customerFirstname,
        $customerLastname,
        $customerMiddlename,
        $customerSuffix,
        $checkoutMethod,
        $remoteIp,
        $customerIsGuest,
        $createdAt,
        $updatedAt,
        $customerEmail
    ) {
        $this->storeId = $storeId;
        $this->cartId = $cartId;
        $this->convertedAt = $convertedAt;
        $this->customerId = $customerId;
        $this->customerPrefix = $customerPrefix;
        $this->customerFirstname = $customerFirstname;
        $this->customerLastname = $customerLastname;
        $this->customerMiddlename = $customerMiddlename;
        $this->customerSuffix = $customerSuffix;
        $this->checkoutMethod = $checkoutMethod;
        $this->remoteIp = $remoteIp;
        $this->customerIsGuest = $customerIsGuest;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @return mixed
     */
    public function getConvertedAt()
    {
        return $this->convertedAt;
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
    public function getCustomerPrefix()
    {
        return $this->customerPrefix;
    }

    /**
     * @return mixed
     */
    public function getCustomerFirstname()
    {
        return $this->customerFirstname;
    }

    /**
     * @return mixed
     */
    public function getCustomerLastname()
    {
        return $this->customerLastname;
    }

    /**
     * @return mixed
     */
    public function getCustomerMiddlename()
    {
        return $this->customerMiddlename;
    }

    /**
     * @return mixed
     */
    public function getCustomerSuffix()
    {
        return $this->customerSuffix;
    }

    /**
     * @return mixed
     */
    public function getCheckoutMethod()
    {
        return $this->checkoutMethod;
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
    public function getCartUserAgent()
    {
        return "";
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function getItems()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['qi' => $resource->getTableName('quote_item')])
            ->joinLeft(
                ['qip' => $resource->getTableName('quote_item')],
                'qi.parent_item_id = qip.item_id',
                ['qip.product_id as parent_product_id']
            )
            ->joinLeft(
                ['pp' => $resource->getTableName('catalog_product_entity')],
                'qip.product_id = pp.entity_id',
                ['pp.sku as parent_sku']
            )
            ->where('qi.quote_id = ?', $this->cartId)
            ->where('qi.quote_id IS NOT NULL');
        $items = [];
        foreach ($conn->fetchAll($select) as $row) {
            $items[] = $this->createItem($this->storeId, $row);
        }
        return $items;
    }


    private function createItem($storeId, $row)
    {
        $item = $this->itemFactory->create();
        $item->setValues(
            $storeId,
            $row['name'],
            $row['product_id'],
            $row['parent_product_id'],
            $row['sku'],
            $row['parent_sku'],
            $row['qty'],
            $row['product_type']
        );
         return $item;
    }
}
