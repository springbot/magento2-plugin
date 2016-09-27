<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Newsletter\Model\Subscriber as MagentoSubscriber;
use Springbot\Main\Api\Entity\Data\SubscriberInterface;

class Subscriber extends MagentoSubscriber implements SubscriberInterface
{
    public $optinStatus;
    public $email;
    public $subscriberId;

    /**
     * @return string
     */
    public function getSubscriberId()
    {
        return parent::getSubscriberId();
    }

    /**
     * @return string
     */
    public function getOptinStatus()
    {
        return parent::getOptinStatus();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return parent::getEmail();
    }

}
