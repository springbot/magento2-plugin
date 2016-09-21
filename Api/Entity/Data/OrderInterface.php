<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface OrderInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface OrderInterface extends \Magento\Sales\Api\Data\OrderInterface
{

    /**
     * @return string
     */
    public function getRedirectMongoId();

    /**
     * @return array
     */
    public function getRedirectMongoIds();

    /**
     * @return string
     */
    public function getTotalPaid();

    /**
     * @return string
     */
    public function getShippingMethod();

    /**
     * @return string
     */
    public function getCouponCode();

    /**
     * @return int
     */
    public function getCustomerId();

}
