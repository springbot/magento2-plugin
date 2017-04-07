<?php

namespace Springbot\Main\Api\Entity\Data;

interface SubscriberInterface
{

    /**
     * @param $storeId
     * @param $optinStatus
     * @param $email
     * @param $subscriberId
     * @return void
     */
    public function setValues($storeId, $optinStatus, $email, $subscriberId);

    /**
     * @return int
     */
    public function getSubscriberId();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getOptinStatus();
}
