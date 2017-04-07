<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Newsletter\Model\Subscriber as MagentoSubscriber;
use Springbot\Main\Api\Entity\Data\SubscriberInterface;

class Subscriber implements SubscriberInterface
{
    public $storeId;
    public $optinStatus;
    public $email;
    public $subscriberId;

    /**
     * @param $storeId
     * @param $optinStatus
     * @param $email
     * @param $subscriberId
     */
    public function setValues($storeId, $optinStatus, $email, $subscriberId)
    {
        $this->storeId = $storeId;
        $this->optinStatus = $optinStatus;
        $this->email = $email;
        $this->subscriberId = $subscriberId;
    }

    /**
     * @return mixed
     */
    public function getOptinStatus()
    {
        return $this->optinStatus;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }
}
