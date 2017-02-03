<?php

namespace Springbot\Main\Model\Api\Entity\Data\Order;

use Springbot\Main\Api\Entity\Data\Order\ShipmentItemInterface;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Shipment
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Order
 */
class ShipmentItem implements ShipmentItemInterface
{
    public $sku;
    public $name;
    public $productId;
    public $qty;

    private $resourceConnection;
    private $itemFactory;

    /**
     * ShipmentItem constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param ItemFactory        $factory
     */
    public function __construct(ResourceConnection $resourceConnection, ItemFactory $factory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->itemFactory = $factory;
    }

    /**
     * ShipmentItem constructor.
     *
     * @param  $sku
     * @param  $name
     * @param  $productId
     * @param  $qty
     * @return void
     */
    public function setValues($sku, $name, $productId, $qty)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->productId = $productId;
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }
}
