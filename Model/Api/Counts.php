<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\CountsInterface;
use Springbot\Main\Model\Api\CountFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class Counts implements CountsInterface
{

    private $resourceConnection;
    private $countFactory;
    private $storeManager;
    private $counts = [];

    /**
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param CountFactory                              $countFactory
     * @param StoreManagerInterface                     $storeManager
     */
    public function __construct(ResourceConnection $resourceConnection, CountFactory $countFactory, StoreManagerInterface $storeManager)
    {
        $this->resourceConnection = $resourceConnection;
        $this->countFactory = $countFactory;
        $this->storeManager = $storeManager;
    }


    public function getCounts($storeId)
    {
        if (($store = $this->storeManager->getStore($storeId)) == null) {
            throw new \Exception("Store not found");
        }
        $websiteId = $store->getWebsiteId();

        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('sales_order')} WHERE store_id = :store_id", ['store_id' => $storeId]);
        $this->addCount('orders', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('quote')} WHERE store_id = :store_id", ['store_id' => $storeId]);
        $this->addCount('carts', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('newsletter_subscriber')} WHERE store_id = :store_id", ['store_id' => $storeId]);
        $this->addCount('subscribers', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('customer_entity')} WHERE store_id = :store_id", ['store_id' => $storeId]);
        $this->addCount('customers', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('sales_order')} WHERE store_id = :store_id AND customer_is_guest = true", ['store_id' => $storeId]);
        $this->addCount('guests', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('eav_attribute_set')}");
        $this->addCount('attribute-sets', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('salesrule')}");
        $this->addCount('rules', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('catalog_product_website')} WHERE website_id = :website_id", ['website_id' => $websiteId]);
        $this->addCount('products', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('cataloginventory_stock_item')} WHERE website_id = :website_id", ['website_id' => $websiteId]);
        $this->addCount('inventory', $this->getCountFromQuery($query));
        $query = $conn->query("SELECT COUNT(*) AS count FROM {$resource->getTableName('catalog_category_entity')}");
        $this->addCount('categories', $this->getCountFromQuery($query));

        return $this->counts;
    }

    public function addCount($type, $count)
    {
        $countObject = $this->countFactory->create();
        $countObject->setEntityType($type);
        $countObject->setCount($count);
        $this->counts[] = $countObject;
    }

    private function getCountFromQuery($query)
    {
        $result = $query->fetch();
        return $result['count'];
    }
}
