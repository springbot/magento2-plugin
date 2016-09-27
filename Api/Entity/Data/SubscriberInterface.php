<?php

namespace Springbot\Main\Api\Entity\Data;

interface SubscriberInterface
{

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
