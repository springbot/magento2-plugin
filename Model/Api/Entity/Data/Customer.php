<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Customer\Model\Customer as MagentoCustomer;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\Data\CustomerInterface;
use Springbot\Main\Model\Api\Entity\Data\Customer\AddressFactory;
use Springbot\Main\Model\Api\Entity\Data\Customer\CustomerAttributeFactory;
/**
 * Class Customer
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Customer implements CustomerInterface
{
    public $storeId;
    public $customerId;
    public $firstName;
    public $lastName;
    public $email;
    public $attributeSetId;
    public $hasPurchase;
    public $billingAddressId;
    public $shippingAddressId;

    private $resourceConnection;
    private $addressFactory;
    private $attributeFactory;

    /**
     * Customer constructor.
     * @param ResourceConnection $resourceConnection
     * @param AddressFactory $addressFactory
     * @param CustomerAttributeFactory $attributeFactory
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        AddressFactory $addressFactory,
        CustomerAttributeFactory $attributeFactory
    )
    {
        $this->resourceConnection = $resourceConnection;
        $this->addressFactory = $addressFactory;
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * @param $storeId
     * @param $customerId
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $attributeSetId
     * @param $billingAddressId
     * @param $shippingAddressId
     * @return void
     */
    public function setValues($storeId, $customerId, $firstName, $lastName, $email, $attributeSetId,
                              $billingAddressId, $shippingAddressId)
    {
        $this->storeId = $storeId;
        $this->customerId = $customerId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->attributeSetId = $attributeSetId;
        $this->billingAddressId = $billingAddressId;
        $this->shippingAddressId = $shippingAddressId;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    /**
     * @return mixed
     */
    public function getHasPurchase()
    {
        $conn = $this->resourceConnection->getConnection();
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$conn->getTableName('sales_order')} WHERE customer_id = :customer_id", ['customer_id' => $this->customerId]);
        $result = $query->fetch();
        return ($result['count'] > 0);
    }

    public function getCustomerAttributes()
    {
        $conn = $this->resourceConnection->getConnection();
        $query = $conn->query("SELECT 
              ea.attribute_code,
              cet.value as `text`,
              ced.value as `datetime`,
              cedec.value as `decimal`,
              cei.value as `int`,
              cev.value as `varchar`
            FROM {$conn->getTableName('eav_attribute')} ea
            LEFT JOIN {$conn->getTableName('customer_entity_text')} cet
                ON (ea.attribute_id = cet.attribute_id)
            LEFT JOIN {$conn->getTableName('customer_entity_datetime')} ced
                ON (ea.attribute_id = ced.attribute_id)
            LEFT JOIN {$conn->getTableName('customer_entity_decimal')} cedec
                ON (ea.attribute_id = cedec.attribute_id)
            LEFT JOIN {$conn->getTableName('customer_entity_int')} cei
                ON (ea.attribute_id = cei.attribute_id)
            LEFT JOIN {$conn->getTableName('customer_entity_varchar')} cev
                ON (ea.attribute_id = cev.attribute_id)
            WHERE cet.entity_id = :entity_id 
             OR ced.entity_id = :entity_id
             OR cedec.entity_id = :entity_id
             OR cei.entity_id = :entity_id 
             OR cev.entity_id = :entity_id
        ", ['entity_id' => $this->customerId]);
        $attributes = [];
        foreach($query->fetchAll() as $attributeRow) {
            $value = null;
            if (isset($attributeRow['text'])) {
                $value = $attributeRow['text'];
            }
            else if (isset($attributeRow['datetime'])) {
                $value = $attributeRow['datetime'];
            }
            else if (isset($attributeRow['decimal'])) {
                $value = $attributeRow['decimal'];
            }
            else if (isset($attributeRow['int'])) {
                $value = $attributeRow['int'];
            }
            else if (isset($attributeRow['varchar'])) {
                $value = $attributeRow['varchar'];
            }
            if ($value !== null) {
                $attribute = $this->attributeFactory->create();
                $attribute->setValues($attributeRow['attribute_code'], $value);
                $attributes[] = $attribute;
            }
        }
        return $attributes;
    }

    public function getShippingAddress()
    {
        return $this->fetchAddress($this->storeId, $this->shippingAddressId);
    }

    public function getBillingAddress()
    {
        return $this->fetchAddress($this->storeId, $this->billingAddressId);
    }

    private function fetchAddress($storeId, $id)
    {
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('customer_address_entity')])
            ->where('entity_id = ?', $id);
        foreach ($conn->fetchAll($select) as $row) {
            $address = $this->addressFactory->create();
            $address->setValues(
                $row['entity_id'],
                true,
                $row['city'],
                $row['company'],
                $row['country_id'],
                $row['fax'],
                $row['firstname'],
                $row['lastname'],
                $row['middlename'],
                $row['postcode'],
                $row['prefix'],
                $row['region'],
                $row['street'],
                $row['suffix'],
                $row['telephone']
            );
            return $address;
        }
        return null;
    }

}
