<?php

namespace Springbot\Main\Model;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Customer;
use Magento\Framework\Model\Context;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;
use Magento\SalesRule\Model\Rule as SalesRule;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Magento\Framework\App\ObjectManager;

class Counts extends AbstractModel
{
    protected $salesRules;
    protected $catalogRules;
    protected $carts;
    protected $orders;
    protected $customers;
    protected $categories;
    protected $attributeSets;
    protected $products;

    /**
     * Counts constructor.
     *
     * @param Context $context
     * @param SalesRule $salesRules
     * @param Quote $carts
     * @param Order $orders
     * @param Customer $customers
     * @param Category $categories
     * @param Product $products
     * @param AttributeSet $attributeSets
     */
    public function __construct(
        Context $context,
        Registry $registry,
        SalesRule $salesRules,
        Quote $carts,
        Order $orders,
        Customer $customers,
        Category $categories,
        Product $products,
        AttributeSet $attributeSets
    )
    {
        $this->salesRules = $salesRules;
        $this->carts = $carts;
        $this->orders = $orders;
        $this->customers = $customers;
        $this->categories = $categories;
        $this->products = $products;
        $this->attributeSets = $attributeSets;
        parent::__construct($context, $registry);
    }

    /**
     * Get all store counts we care about.
     *
     * @param int $storeId
     * @return array
     */
    public function getCounts($storeId)
    {
        // Construct the array to be displayed via the REST endpoint
        $array = [
            "counts" => [
                "sales_rules" => self::getRuleCount($storeId),
                "carts" => self::getEntityCount($this->carts, $storeId),
                "orders" => self::getEntityCount($this->orders, $storeId),
                "customers" => self::getEntityCount($this->customers, $storeId),
                "categories" => self::getCategoryCount($storeId),
                "products" => $this->getProductCount($storeId)
            ]
        ];

        // Return our array for display via the REST API
        return $array;
    }

    /**
     * Get the total count for a particular entity type
     *
     * @param AbstractModel $entity
     * @param int $storeId
     * @return int
     */
    private function getEntityCount($entity, $storeId)
    {
        $collection = $entity->getCollection();
        $collection->addFieldToFilter('store_id', $storeId);

        // Return sales array count
        return $collection->count();
    }

    private function getCategoryCount($storeId)
    {
        $om = ObjectManager::getInstance();
        $storeModel = $om->create('Magento\Store\Model\Store');
        $store = $storeModel->load($storeId);
        $rootCategory = $this->categories->load($store->getRootCategoryId());
        $collection = $this->categories->getCollection();
        $collection->addFieldToFilter('path', array('like' => $rootCategory->getPath() . '%'));
        return $collection->count();
    }

    private function getRuleCount($storeId)
    {
        $collection = $this->salesRules->getCollection();
        $om = ObjectManager::getInstance();
        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $store = $manager->getStore($storeId);
        $collection->addWebsiteFilter($store->getWebsiteId());
        return $collection->count();
    }

    private function getProductCount($storeId)
    {
        $collection = $this->products->getCollection();
        $om = ObjectManager::getInstance();
        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $store = $manager->getStore($storeId);
        $collection->addWebsiteFilter($store->getWebsiteId());
        return $collection->count();
    }


}
