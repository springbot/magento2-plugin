<?php

namespace Springbot\Main\Helper\Api;

use Magento\CatalogRule\Model\Rule as CatalogRule;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Quote\Model\Quote;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\Rule as SalesRule;
use Magento\Sales\Model\Order;
use Magento\Customer\Model\Customer;
use Magento\Catalog\Model\Category;

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
    protected $_simpleProducts;
    protected $_configurableProducts;
    protected $_bundledProducts;
    protected $_groupedProducts;
    protected $_virtualProducts;

    /**
     * Counts constructor.
     *
     * @param Context     $context
     * @param SalesRule   $salesRules
     * @param CatalogRule $catalogRules
     */
    public function __construct(
        Context $context,
        SalesRule $salesRules,
        CatalogRule $catalogRules,
        Coupon $coupons,
        Quote $carts,
        Order $orders,
        Customer $customers,
        Category $categories
    )
    {
        $this->_salesRules = $salesRules;
        $this->_catalogRules = $catalogRules;
        $this->_coupons = $coupons;
        $this->_carts = $carts;
        $this->_orders = $orders;
        $this->_customers = $customers;
        $this->_categories = $categories;
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
                    "catalog_rules" => self::getEntityCount($this->_catalogRules)
                ],
                "coupons"        => self::getEntityCount($this->_coupons),
                "carts"          => self::getEntityCount($this->_carts),
                "orders"         => self::getEntityCount($this->_orders),
                "customers"      => self::getEntityCount($this->_customers),
                "categories"     => self::getEntityCount($this->_categories),
                "attribute_sets" => [
                    "customer_attribute_sets" => null,
                    "product_attribute_sets"  => null
                ],
                "products"       => [
                    "simple"       => null,
                    "configurable" => null,
                    "bundled"      => null,
                    "grouped"      => null,
                    "virtual"      => null
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
    protected function getEntityCount(AbstractModel $entity)
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
}
