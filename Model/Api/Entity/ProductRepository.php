<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\ProductFactory;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Api\Entity
 */
class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    /* @var ProductFactory $productFactory */
    protected $productFactory;

    /**
     * OrderRepository constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\App\ObjectManager $objectManager
     * @param \Springbot\Main\Model\Api\Entity\Data\ProductFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        ObjectManager $objectManager,
        ProductFactory $factory
    )
    {
        $this->productFactory = $factory;
        parent::__construct($request, $resourceConnection, $objectManager);
    }

    public function getList($storeId)
    {
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('catalog_product_entity')]);
        $this->filterResults($select);

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createProduct($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $productId)
    {
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from([$conn->getTableName('catalog_product_entity')])
            ->where('entity_id', $productId);
        $this->filterResults($select);

        foreach ($conn->fetchAll($select) as $row) {
            return $this->createProduct($storeId, $row);
        }
        return null;
    }

    private function createProduct($storeId, $row)
    {
        $product = $this->productFactory->create();
        $product->setValues(
            $storeId,
            $row['entity_id'],
            $row['sku'],
            $row['type_id'],
            $row['created_at'], 
            $row['updated_at'],
            $row['attribute_set_id']
        );
        return $product;
    }

}
