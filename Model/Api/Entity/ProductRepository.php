<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\ProductFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ProductRepository
 *
 * @package Springbot\Main\Model\Api\Entity
 */
class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    /* @var ProductFactory $productFactory */
    protected $productFactory;

    private $storeManager;

    /**
     * OrderRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http                  $request
     * @param \Magento\Framework\App\ResourceConnection            $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\ProductFactory $factory
     * @param StoreManagerInterface                                $storeManager
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        ProductFactory $factory,
        StoreManagerInterface $storeManager
    ) {

        $this->storeManager = $storeManager;
        $this->productFactory = $factory;
        parent::__construct($request, $resourceConnection);
    }

    public function getList($storeId)
    {
        if (($store = $this->storeManager->getStore($storeId)) == null) {
            throw new \Exception("Store not found");
        }
        $websiteId = $store->getWebsiteId();
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['cpw' => $resource->getTableName('catalog_product_website')])
            ->joinLeft(['cpe' => $resource->getTableName('catalog_product_entity')], 'cpe.entity_id = cpw.product_id', ['cpe.*'])
            ->where('website_id = ?', $websiteId);
        $this->filterResults($select);

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createProduct($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $productId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('catalog_product_entity')])
            ->where('entity_id = ?', $productId);

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
