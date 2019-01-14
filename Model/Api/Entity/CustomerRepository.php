<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\Request\Http as HttpRequest;
use Springbot\Main\Api\Entity\CustomerRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\CustomerFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Request\Http;

/**
 *  CustomerRepository
 *
 * @package Springbot\Main\Api
 */
class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{

    /* @var CustomerFactory $customerFactory */
    protected $customerFactory;

    private $customerAttributeSetId;

    /**
     * OrderRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http                   $request
     * @param \Magento\Framework\App\ResourceConnection             $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\CustomerFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        CustomerFactory $factory
    ) {

        $this->customerFactory = $factory;
        parent::__construct($request, $resourceConnection);
    }

    public function getList($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['ce' => $resource->getTableName('customer_entity')])
            ->where('store_id = ?', $storeId);
        $this->filterResults($select);
        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createCustomer($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $customerId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('customer_entity')])
            ->where('entity_id = ?', $customerId);
        foreach ($conn->fetchAll($select) as $row) {
            return $this->createCustomer($storeId, $row);
        }
        return null;
    }

    private function createCustomer($storeId, $row)
    {
        $customer = $this->customerFactory->create();
        $customer->setValues(
            $storeId,
            $row['entity_id'],
            $row['firstname'],
            $row['lastname'],
            $row['email'],
            $row['group_id'],
            $this->fetchCustomerAttributeSetId(),
            $row['default_billing'],
            $row['default_shipping']
        );
        return $customer;
    }

    private function fetchCustomerAttributeSetId()
    {
        if (isset($this->customerAttributeSetId)) {
            return $this->customerAttributeSetId;
        }
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['eas' => $resource->getTableName('eav_attribute_set')])
            ->joinLeft(['eat' => $resource->getTableName('eav_entity_type')], 'eas.entity_type_id = eat.entity_type_id', ['eat.entity_type_code']);
        foreach ($conn->fetchAll($select) as $row) {
            $this->customerAttributeSetId = $row['attribute_set_id'];
            return $this->customerAttributeSetId;
        }
        return null;
    }
}
