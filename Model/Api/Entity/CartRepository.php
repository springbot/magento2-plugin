<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\CartRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\CartFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Request\Http;

/**
 * Class CartRepository
 *
 * @package Springbot\Main\Model\Api\Entity
 */
class CartRepository extends AbstractRepository implements CartRepositoryInterface
{

    private $cartFactory;

    /**
     * CartRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http               $request
     * @param \Magento\Framework\App\ResourceConnection         $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\CartFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        CartFactory $factory
    ) {

        $this->cartFactory = $factory;
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
            ->from(['q' => $resource->getTableName('quote')])
            ->where('store_id = ?', $storeId);
        $this->filterResults($select);
        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createCart($storeId, $row);
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $cartId
     * @return $this
     */
    public function getFromId($storeId, $cartId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['q' => $resource->getTableName('quote')])
            ->where('store_id = ?', $storeId)
            ->where('entity_id = ?', $cartId);
        foreach ($conn->fetchAll($select) as $row) {
            return $this->createCart($storeId, $row);
        }
        return null;
    }


    private function createCart($storeId, $row)
    {
        $category = $this->cartFactory->create();
        $category->setValues(
            $storeId,
            $row['entity_id'],
            $row['converted_at'],
            $row['customer_id'],
            $row['customer_prefix'],
            $row['customer_firstname'],
            $row['customer_lastname'],
            $row['customer_middlename'],
            $row['customer_suffix'],
            $row['checkout_method'],
            $row['remote_ip'],
            $row['customer_is_guest'],
            $row['created_at'],
            $row['updated_at'],
            $row['customer_email']
        );
        return $category;
    }
}
