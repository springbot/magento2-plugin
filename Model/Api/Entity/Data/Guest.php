<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Api\Entity\Data\GuestInterface;
use Springbot\Main\Model\Api\Entity\Data\Customer\AddressFactory;

/**
 *  Guest
 *
 * Springbot "guests" are customers for which there is no customer record. Since they have no customer record, we
 * determine guests from the order objects.
 *
 * @package Springbot\Main\Api\Data
 */
class Guest implements GuestInterface
{
    private static $offset = 100000000;

    public $storeId;
    public $orderId;
    public $firstname;
    public $lastname;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $billingAddressId;
    public $shippingAddressId;

    private $resourceConnection;
    private $addressFactory;

    /**
     * Guest constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param AddressFactory     $addressFactory
     */
    public function __construct(ResourceConnection $resourceConnection, AddressFactory $addressFactory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param $storeId
     * @param $orderId
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $createdAt
     * @param $updatedAt
     * @param $billingAddressId
     * @param $shippingAddressId
     * @return void
     */
    public function setValues(
        $storeId,
        $orderId,
        $firstname,
        $lastname,
        $email,
        $createdAt,
        $updatedAt,
        $billingAddressId,
        $shippingAddressId
    ) {

        $this->storeId = $storeId;
        $this->orderId = $orderId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->billingAddressId = $billingAddressId;
        $this->shippingAddressId = $shippingAddressId;
    }

    /**
     * @return mixed
     */
    public function getGuestId()
    {
        return $this->orderId + self::$offset;
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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getBillingAddress()
    {
        return $this->fetchAddress($this->storeId, $this->billingAddressId);
    }

    public function getShippingAddress()
    {
        return $this->fetchAddress($this->storeId, $this->shippingAddressId);
    }

    private function fetchAddress($storeId, $id)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('sales_order_address')])
            ->where('entity_id = ?', $this->billingAddressId);
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
