<?php

namespace Springbot\Main\Helper\Api;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
    as ProductAttributeSets;
use Magento\CatalogRule\Model\Rule as CatalogRule;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute\Collection
    as CustomerAttributeSets;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\Rule as SalesRule;

class Counts extends AbstractHelper
{
    protected $_salesRules;
    protected $_catalogRules;
    protected $_coupons;
    protected $_carts;
    protected $_orders;
    protected $_customers;
    protected $_categories;
    protected $_customerAttributeSets;
    protected $_productAttributeSets;
    protected $_products;

    /**
     * Counts constructor.
     *
     * @param Context               $context
     * @param SalesRule             $salesRules
     * @param CatalogRule           $catalogRules
     * @param Coupon                $coupons
     * @param Quote                 $carts
     * @param Order                 $orders
     * @param Customer              $customers
     * @param Category              $categories
     * @param Product               $products
     * @param CustomerAttributeSets $customerAttributeSets
     * @param ProductAttributeSets  $productAttributeSets
     */
    public function __construct(
        Context $context,
        SalesRule $salesRules,
        CatalogRule $catalogRules,
        Coupon $coupons,
        Quote $carts,
        Order $orders,
        Customer $customers,
        Category $categories,
        Product $products,
        ProductAttributeSets $productAttributeSets,
        CustomerAttributeSets $customerAttributeSets
    )
    {
        $this->_salesRules = $salesRules;
        $this->_catalogRules = $catalogRules;
        $this->_coupons = $coupons;
        $this->_carts = $carts;
        $this->_orders = $orders;
        $this->_customers = $customers;
        $this->_categories = $categories;
        $this->_products = $products;
        $this->_customerAttributeSets = $customerAttributeSets;
        $this->_productAttributeSets = $productAttributeSets;
        parent::__construct($context);
    }

    /**
     * Get all store counts we care about.
     *
     * @param int|null $id
     *
     * @return array
     */
    public function getCounts()
    {
        // Construct the array to be displayed via the REST endpoint
        $array = [
            "counts" => [
                "rules"          => [
                    "sales_rules"   => self::getEntityCount($this->_salesRules),
                    "catalog_rules" => self::getEntityCount(
                        $this->_catalogRules
                    )
                ],
                "coupons"        => self::getEntityCount($this->_coupons),
                "carts"          => self::getEntityCount($this->_carts),
                "orders"         => self::getEntityCount($this->_orders),
                "customers"      => self::getEntityCount($this->_customers),
                "categories"     => self::getEntityCount($this->_categories),
                "attribute_sets" => [
                    "customer_attribute_sets" => self::getAttributeCount(
                        'customer'
                    ),
                    "product_attribute_sets"  => self::getAttributeCount(
                        'products'
                    )
                ],
                "products"       => [
                    "simple"       => self::getProductCount('simple'),
                    "configurable" => self::getProductCount('configurable'),
                    "bundled"      => self::getProductCount('bundled'),
                    "grouped"      => self::getProductCount('grouped'),
                    "virtual"      => self::getProductCount('virtual')
                ]
            ]
        ];

        // Return our array for display via the REST API
        return $array;

    }

    /**
     * Get the total count for a particular entity type
     *
     * @param AbstractModel $entity
     *
     * @return int
     */
    protected function getEntityCount($entity)
    {
        // Initialize empty array
        $array = [];
        // Get sales rule collection
        $collection = $entity->getCollection();
        // Iterate through the collection and add it to the array
        foreach ($collection as $item) {
            $array[] = $item;
        }
        // Return sales array count
        return count($array);
    }

    protected function getAttributeCount($entityType)
    {
        if ($entityType === 'customer') {
            $attributes = $this->_customerAttributeSets->getItems();
            return count($attributes);
        } else {
            if ($entityType === 'products') {
                $attributes = $this->_productAttributeSets->getItems();
                return count($attributes);
            }
        }

        return false;
    }

    protected function getProductCount($typeId)
    {
        // Initialize empty array
        $array = [];
        // Get Product collection
        $collection = $this->_products->getCollection();
        // Filter by type
        $collection->addAttributeToFilter('type_id', $typeId);
        // Iterate through the collection and add it to the array
        foreach ($collection as $product) {
            $array[] = $product;
        }
        // Return Product array count
        return count($array);
    }
}
