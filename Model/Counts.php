<?php

namespace Springbot\Main\Model;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection as ProductAttributeSets;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute\Collection as CustomerAttributeSets;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\Rule as SalesRule;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;

class Counts extends AbstractHelper
{
    protected $_salesRules;
    protected $_catalogRules;
    protected $_carts;
    protected $_orders;
    protected $_customers;
    protected $_categories;
    protected $_attributeSets;
    protected $_products;

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
        SalesRule $salesRules,
        Quote $carts,
        Order $orders,
        Customer $customers,
        Category $categories,
        Product $products,
        AttributeSet $attributeSets
    )
    {
        $this->_salesRules = $salesRules;
        $this->_carts = $carts;
        $this->_orders = $orders;
        $this->_customers = $customers;
        $this->_categories = $categories;
        $this->_products = $products;
        $this->_attributeSets = $attributeSets;
        parent::__construct($context);
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
                "carts" => self::getEntityCount($this->_carts, $storeId),
                "orders" => self::getEntityCount($this->_orders, $storeId),
                "customers" => self::getEntityCount($this->_customers, $storeId),
                "categories" => self::getCategoryCount($storeId),
                "attribute_sets" => $this->getAttriubteSetCount($storeId),
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
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $storeModel = $om->create('Magento\Store\Model\Store');
        $store = $storeModel->load($storeId);
        $rootCategory = $this->_categories->load($store->getRootCategoryId());
        $collection = $this->_categories->getCollection();
        $collection->addFieldToFilter('path', array('like' => $rootCategory->getPath() . '%'));
        return $collection->count();
    }

    private function getRuleCount($storeId)
    {
        $collection = $this->_salesRules->getCollection();
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $store = $manager->getStore($storeId);
        $collection->addWebsiteFilter($store->getWebsiteId());
        return $collection->count();
    }

    private function getProductCount($storeId)
    {
        $collection = $this->_products->getCollection();
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $store = $manager->getStore($storeId);
        $collection->addWebsiteFilter($store->getWebsiteId());
        return $collection->count();
    }

    private function getAttriubteSetCount($storeId)
    {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $attributeSet = $om->get('Magento\Catalog\Model\Product\AttributeSet\Options');
        $collection = $attributeSet->getCollection();

        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $store = $manager->getStore($storeId);
        $collection->addWebsiteFilter($store->getWebsiteId());
        return $collection->count();
    }

}
