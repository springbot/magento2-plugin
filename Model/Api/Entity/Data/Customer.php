<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Customer\Model\Customer as MagentoCustomer;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\Data\CustomerInterface;
use Springbot\Main\Model\Api\Entity\Data\Customer\AddressFactory;
use Springbot\Main\Model\Api\Entity\Data\Customer\CustomerAttributeFactory;

/**
 * Class Customer
 *
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
     *
     * @param ResourceConnection       $resourceConnection
     * @param AddressFactory           $addressFactory
     * @param CustomerAttributeFactory $attributeFactory
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        AddressFactory $addressFactory,
        CustomerAttributeFactory $attributeFactory
    ) {

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
    public function setValues(
        $storeId,
        $customerId,
        $firstName,
        $lastName,
        $email,
        $attributeSetId,
        $billingAddressId,
        $shippingAddressId
    ) {

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
        $resource =  $this->resourceConnection;
        $conn = $resource->getConnection();
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('sales_order')} WHERE customer_id = :customer_id", ['customer_id' => $this->customerId]);
        $result = $query->fetch();
        return ($result['count'] > 0);
    }

    public function getCustomerAttributes()
    {
        $resource =  $this->resourceConnection;
        $conn = $resource->getConnection();
        $query = $conn->query(
            "
            SELECT ea.attribute_code AS `code`, eav.value  AS 'value'
            FROM {$resource->getTableName('customer_entity')} ce
              LEFT JOIN {$resource->getTableName('customer_entity_datetime')} eav ON (ce.entity_id = eav.entity_id)
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (ce.entity_id = :entity_id)
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('customer_entity')} ce
              LEFT JOIN {$resource->getTableName('customer_entity_decimal')} eav ON (ce.entity_id = eav.entity_id)
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (ce.entity_id = :entity_id)
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('customer_entity')} ce
              LEFT JOIN {$resource->getTableName('customer_entity_int')} eav ON (ce.entity_id = eav.entity_id)
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (ce.entity_id = :entity_id)
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('customer_entity')} ce
              LEFT JOIN {$resource->getTableName('customer_entity_text')} eav ON (ce.entity_id = eav.entity_id)
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (ce.entity_id = :entity_id)
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('customer_entity')} ce
              LEFT JOIN {$resource->getTableName('customer_entity_varchar')} eav ON (ce.entity_id = eav.entity_id)
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (ce.entity_id = :entity_id);
        ",
            ['entity_id' => $this->customerId]
        );
        $attributes = [];
        foreach ($query->fetchAll() as $attributeRow) {
            if ($attributeRow['value'] !== null) {
                $attribute = $this->attributeFactory->create();
                $attribute->setValues($attributeRow['code'], $attributeRow['value']);
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
        $resource =  $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('customer_address_entity')])
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
