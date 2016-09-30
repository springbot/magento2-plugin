<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\App\ResourceConnection;

class CountsResponse
{

    private $resourceConnection;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function getAttributeSets()
    {
        return 0;
    }

    public function getCarts()
    {
        return 0;
    }

    public function getCategories()
    {
        return 0;
    }

    public function getCustomers()
    {
        return 0;
    }

    public function getInventory()
    {
        return 0;
    }

    public function getOrders()
    {
        return 0;
    }

    public function getProducts()
    {
        return 0;
    }

    public function getRules()
    {
        return 0;
    }

    public function getSubscribers()
    {
        return 0;
    }

    public function getGuests()
    {
        return 0;
    }

}
