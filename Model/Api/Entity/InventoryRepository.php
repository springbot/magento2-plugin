<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;
use Springbot\Main\Api\Entity\InventoryRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\InventoryFactory;

/**
 *  InventoryRepository
 * @package Springbot\Main\Api
 */
class InventoryRepository extends AbstractRepository implements InventoryRepositoryInterface
{

    /* @var InventoryFactory $inventoryFactor */
    protected $inventoryFactory;

    /**
     * OrderRepository constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\App\ObjectManager $objectManager
     * @param \Springbot\Main\Model\Api\Entity\Data\InventoryFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        ObjectManager $objectManager,
        InventoryFactory $factory
    )
    {
        $this->inventoryFactory = $factory;
        parent::__construct($request, $resourceConnection, $objectManager);
    }

    public function getList($storeId)
    {
        $select = $this->getSelect();
        $this->filterResults($select);
        $ret = [];
        foreach ($this->resourceConnection->getConnection()->fetchAll($select) as $row) {
            $ret[] = $this->createInventory($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $inventoryId)
    {
        $select = $this->getSelect()->where('item_id = ?', $inventoryId);
        foreach ($this->resourceConnection->getConnection()->fetchAll($select) as $row) {
            return $this->createInventory($storeId, $row);
        }
    }

    private function createInventory($storeId, $row)
    {
        $inventory = $this->inventoryFactory->create();
        /* @var \Springbot\Main\Model\Api\Entity\Data\Inventory $inventory */
        $inventory->setValues(
            $storeId,
            $row['product_id'],
            $row['manage_stock'],
            $row['min_qty'],
            $row['qty'],
            $row['item_id'],
            $row['is_in_stock'],
            $row['min_sale_qty'],
            $row['sku']
        );
        return $inventory;
    }

    private function getSelect()
    {
        $conn = $this->resourceConnection->getConnection();
        return $conn->select()
            ->from(['stock' => $conn->getTableName('cataloginventory_stock_item')])
            ->joinLeft(
                ['prod' => $conn->getTableName('catalog_product_entity')],
                'prod.entity_id = stock.product_id'
            );
    }

}
