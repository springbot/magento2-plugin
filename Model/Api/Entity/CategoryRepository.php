<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\CategoryRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\CategoryFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Request\Http;
use Magento\Store\Model\StoreManagerInterface;

/**
 * CategoryRepository
 *
 * @package Springbot\Main\Api
 */
class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    /* @var CategoryFactory $categoryFactory */
    protected $categoryFactory;

    private $storeManager;


    /**
     * CategoryRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http                   $request
     * @param \Magento\Framework\App\ResourceConnection             $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\CategoryFactory $factory
     * @param StoreManagerInterface                                 $storeManager;
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        CategoryFactory $factory,
        StoreManagerInterface $storeManager
    ) {

        $this->categoryFactory = $factory;
        $this->storeManager = $storeManager;
        parent::__construct($request, $resourceConnection);
    }

    /**
     * @param int $storeId
     * @return \Springbot\Main\Model\Api\Entity\Data\Category[]
     * @throws \Exception
     */
    public function getList($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['cce' => $resource->getTableName('catalog_category_entity')])
            ->joinLeft(['ur' => $resource->getTableName('url_rewrite')], 'ur.entity_id = cce.entity_id')
            ->where('ur.entity_type = ?', 'category')
            ->where('ur.store_id = ?', $storeId);
        $this->filterResults($select);
        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createCategory($storeId, $row);
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $categoryId
     * @return \Springbot\Main\Model\Api\Entity\Data\Category
     */
    public function getFromId($storeId, $categoryId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['cce' => $resource->getTableName('catalog_category_entity')])
            ->joinLeft(['ur' => $resource->getTableName('url_rewrite')], 'ur.entity_id = cce.entity_id')
            ->where('cce.entity_id = ?', $categoryId)
            ->where('ur.store_id = ?', $storeId);
        foreach ($conn->fetchAll($select) as $row) {
            return $this->createCategory($storeId, $row);
        }
        return null;
    }

    private function createCategory($storeId, $row)
    {
        $category = $this->categoryFactory->create();
        $category->setValues(
            $storeId,
            $row['entity_id'],
            $row['level'],
            $row['path'],
            $row['created_at'],
            $row['updated_at'],
            $row['request_path'],
            $row['target_path']
        );
        return $category;
    }
}
