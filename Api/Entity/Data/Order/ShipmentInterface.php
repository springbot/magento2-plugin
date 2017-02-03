<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * Interface ShipmentInterface
 *
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface ShipmentInterface
{

    /**
     * @param $shipmentId
     * @param $trackingNumber
     * @param $carrierCode
     * @param $title
     * @param $shipTo
     * @param $shipmentStatus
     * @return void
     */
    public function setValues($shipmentId, $trackingNumber, $carrierCode, $title, $shipTo, $shipmentStatus);

    /**
     * @return int
     */
    public function getShipmentId();

    /**
     * @return string
     */
    public function getTrackingNumber();

    /**
     * @return string
     */
    public function getCarrierCode();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getShipTo();

    /**
     * @return string
     */
    public function getShipmentStatus();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ShipmentItemInterface[]
     */
    public function getItems();
}
