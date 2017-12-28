<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface RuleInterface
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface RuleInterface
{

    /**
     * @param $storeId
     * @param $ruleId
     * @param $isActive
     * @param $name
     * @param $description
     * @param $conditions
     * @param $actions
     * @param $fromDate
     * @param $toDate
     * @param $usesPerCoupon
     * @param $usesPerCustomer
     * @param $stopRulesProcessing
     * @param $isAdvanced
     * @param $productIds
     * @param $sortOrder
     * @param $simpleAction
     * @param $discountAmount
     * @param $discountQty
     * @param $discountStep
     * @param $isSimpleFreeShipping
     * @param $appliesToShipping
     * @param $timesUsed
     * @param $isRss
     * @return void
     */
    public function setValues(
        $storeId,
        $ruleId,
        $isActive,
        $name,
        $description,
        $conditions,
        $actions,
        $fromDate,
        $toDate,
        $usesPerCoupon,
        $usesPerCustomer,
        $stopRulesProcessing,
        $isAdvanced,
        $productIds,
        $sortOrder,
        $simpleAction,
        $discountAmount,
        $discountQty,
        $discountStep,
        $isSimpleFreeShipping,
        $appliesToShipping,
        $timesUsed,
        $isRss
    );

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
    public function getCouponCodes();

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
     * @return int[]
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
     * @return int[]
     */
    public function getWebsiteIds();

    /**
     * @return int[]
     */
    public function getCustomerGroupIds();
}
