<?php

namespace Springbot\Main\Model\Api\Amazon;

use Springbot\Main\Api\Amazon\CreatedOrderInterface;

class CreatedOrder implements CreatedOrderInterface
{

    private $id;
    private $amazonOrderId;
    private $orderId;
    private $storeId;

    /**
     * Address constructor.
     * @param int $id
     * @param string $amazonOrderId
     * @param int $orderId
     * @param int $storeId
     */
    public function __construct($id, $amazonOrderId, $orderId, $storeId)
    {
        $this->id = $id;
        $this->amazonOrderId = $amazonOrderId;
        $this->orderId = $orderId;
        $this->storeId = $storeId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAmazonOrderId()
    {
        return $this->amazonOrderId;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
