<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface RuleInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface RuleInterface
{
    /**
     * @return int
     */
    public function getRuleId();

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getCouponCode();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getConditions();

    /**
     * @return string
     */
    public function getActions();

    /**
     * @return string
     */
    public function getFromDate();

    /**
     * @return string
     */
    public function getToDate();

    /**
     * @return int
     */
    public function getUsesPerCoupon();

    /**
     * @return int
     */
    public function getUsesPerCustomer();

    /**
     * @return bool
     */
    public function getStopRulesProcessing();

    /**
     * @return bool
     */
    public function getIsAdvanced();

    /**
     * @return array
     */
    public function getProductIds();

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @return bool
     */
    public function getSimpleAction();

    /**
     * @return string
     */
    public function getDiscountAmount();

    /**
     * @return int
     */
    public function getDiscountQty();

    /**
     * @return string
     */
    public function getDiscountStep();

    /**
     * @return bool
     */
    public function getIsSimpleFreeShipping();

    /**
     * @return bool
     */
    public function getAppliesToShipping();

    /**
     * @return int
     */
    public function getTimesUsed();

    /**
     * @return bool
     */
    public function getIsRss();

    /**
     * @return array
     */
    public function getWebsiteIds();

    /**
     * @return array
     */
    public function getCustomerGroupIds();

}
