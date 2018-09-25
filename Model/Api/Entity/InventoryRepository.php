<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\InventoryRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\InventoryFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 *  InventoryRepository
 *
 * @package Springbot\Main\Api
 */
class InventoryRepository extends AbstractRepository implements InventoryRepositoryInterface
{

    /* @var InventoryFactory $inventoryFactor */
    protected $inventoryFactory;

    private $storeManager;

    /**
     * OrderRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http                    $request
     * @param \Magento\Framework\App\ResourceConnection              $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\InventoryFactory $factory
     * @param StoreManagerInterface                                  $storeManager
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        InventoryFactory $factory,
        StoreManagerInterface $storeManager
    ) {

        $this->inventoryFactory = $factory;
        $this->storeManager = $storeManager;
        parent::__construct($request, $resourceConnection);
    }

    public function getList($storeId)
    {
        $select = $this->getSelect($storeId);
        $this->filterResults($select);
        $ret = [];
        foreach ($this->resourceConnection->getConnection()->fetchAll($select) as $row) {
            $ret[] = $this->createInventory($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $inventoryId)
    {
        $select = $this->getSelect($storeId)
            ->where('item_id = ?', $inventoryId);
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

    private function getSelect($storeId)
    {
        if (($store = $this->storeManager->getStore($storeId)) === null) {
            throw new \Exception("Store not found: {$storeId}");
        }
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        return $conn->select()
            ->from(['stock' => $resource->getTableName('cataloginventory_stock_item')])
            ->joinLeft(
                ['prod' => $resource->getTableName('catalog_product_entity')],
                'prod.entity_id = stock.product_id'
            );
    }
}
