<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\StoresInterface;
use Springbot\Main\Model\Api\StoreFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Stores
 *
 * @package Springbot\Main\Model\Api
 */
class Stores implements StoresInterface
{
    /* @var StoreFactory $storeFactory */
    private $storeFactory;

    private $resourceConnection;

    /**
     * OrderRepository constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param StoreFactory       $factory
     */
    public function __construct(ResourceConnection $resourceConnection, StoreFactory $factory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->storeFactory = $factory;
    }

    /**
     * @return string[]
     */
    public function getStores()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['s' => $resource->getTableName('store')])
            ->joinLeft(
                ['sw' => $resource->getTableName('store_website')],
                's.website_id = sw.website_id',
                ['sw.code AS website_code', 'sw.name AS website_name']
            );

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createStore($row);
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @return $this
     */
    public function getFromId($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['s' => $resource->getTableName('store')])
            ->joinLeft(
                ['sw' => $resource->getTableName('store_website')],
                's.website_id = sw.website_id',
                ['sw.code AS website_code', 'sw.name AS website_name']
            )
            ->where('s.store_id = ?', $storeId);
        foreach ($conn->fetchAll($select) as $row) {
            return $this->createStore($row);
        }
    }


    private function createStore($row)
    {
        $store = $this->storeFactory->create();
        $store->setValues(
            $row['store_id'],
            $row['website_id'],
            $row['name'],
            $row['code'],
            $row['website_name'],
            $row['website_code'],
            $row['is_active']
        );
        return $store;
    }
}
