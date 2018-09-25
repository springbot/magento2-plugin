<?php

namespace Springbot\Main\Model\Api\Entity\Data\Order;

use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\Entity\Data\Order\ShipmentInterface;
use Springbot\Main\Model\Api\Entity\Data\Order\ShipmentItemFactory;

/**
 * Class Shipment
 *
 * @package Springbot\Main\Model\Api\Entity\Data\Order
 */
class Shipment implements ShipmentInterface
{

    public $shipmentId;
    public $trackingNumber;
    public $carrierCode;
    public $title;
    public $shipTo;
    public $shipmentStatus;

    private $resourceConnection;
    private $shipmentItemFactory;

    public function __construct(ResourceConnection $resourceConnection, ShipmentItemFactory $factory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->shipmentItemFactory = $factory;
    }

    /**
     * @param $shipmentId
     * @param $trackingNumber
     * @param $carrierCode
     * @param $title
     * @param $shipTo
     * @param $shipmentStatus
     * @return void
     */
    public function setValues($shipmentId, $trackingNumber, $carrierCode, $title, $shipTo, $shipmentStatus)
    {
        $this->shipmentId = $shipmentId;
        $this->trackingNumber = $trackingNumber;
        $this->carrierCode = $carrierCode;
        $this->title = $title;
        $this->shipTo = $shipTo;
        $this->shipmentStatus = $shipmentStatus;
    }

    /**
     * @return int
     */
    public function getShipmentId()
    {
        return $this->shipmentId;
    }

    /**
     * @return mixed
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @return mixed
     */
    public function getCarrierCode()
    {
        return $this->carrierCode;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getShipTo()
    {
        return $this->shipTo;
    }

    /**
     * @return mixed
     */
    public function getShipmentStatus()
    {
        return $this->shipmentStatus;
    }

    public function getItems()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['ssi' => $resource->getTableName('sales_shipment_item')])
            ->where('ssi.parent_id = ?', $this->shipmentId);
        $shipmentItems = [];
        foreach ($conn->fetchAll($select) as $row) {
            $shipmentItem = $this->shipmentItemFactory->create();
            $shipmentItem->setValues(
                $row['sku'],
                $row['name'],
                $row['product_id'],
                $row['qty']
            );
            $shipmentItems[] = $shipmentItem;
        }
        return $shipmentItems;
    }
}
