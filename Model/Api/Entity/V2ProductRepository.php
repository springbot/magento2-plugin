<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\V2ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Model\Api\Entity\Data\ProductFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Api\Entity
 */
class V2ProductRepository extends AbstractRepository implements V2ProductRepositoryInterface
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
        HttpRequest $request,
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
            $ret[] = $this->getFromId($storeId, $row['entity_id']);
        }
        return $ret;
    }

    public function getFromId($storeId, $productId)
    {
        return $this->getSpringbotModel()->load($productId);
    }

    public function getSpringbotModel()
    {
        $om = ObjectManager::getInstance();
        return $om->create('Springbot\Main\Model\Api\Entity\Data\V2Product');
    }
}