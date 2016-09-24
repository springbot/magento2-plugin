<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\SalesRule\Model\Rule as MagentoRule;
use Springbot\Main\Api\Entity\Data\RuleInterface;

/**
 *  Rule
 * @package Springbot\Main\Api\Data
 */
class Rule extends MagentoRule implements RuleInterface
{
    public function getRuleId()
    {
        return parent::getEntityId();
    }

    public function getIsActive()
    {
        return parent::getIsActive();
    }

    public function getName()
    {
        return parent::getName();
    }

    public function getCouponCode()
    {
        return parent::getCouponCode();
    }

    public function getDescription()
    {
        return parent::getDescription();
    }

    public function getConditions()
    {
        return serialize(parent::getConditions()->asArray());
    }

    public function getActions()
    {
        return serialize(parent::getActions()->asArray());
    }

    public function getFromDate()
    {
        return parent::getFromDate();
    }

    public function getToDate()
    {
        return parent::getToDate();
    }

    public function getUsesPerCoupon()
    {
        return parent::getUsesPerCoupon();
    }

    public function getUsesPerCustomer()
    {
        return parent::getUsesPerCustomer();
    }

    public function getStopRulesProcessing()
    {
        return parent::getStopRulesProcessing();
    }

    public function getIsAdvanced()
    {
        return parent::getIsAdvanced();
    }

    public function getProductIds()
    {
        return parent::getProductIds();
    }

    public function getSortOrder()
    {
        return parent::getSortOrder();
    }

    public function getSimpleAction()
    {
        return parent::getSimpleAction();
    }

    public function getDiscountAmount()
    {
        return parent::getDiscountAmount();
    }

    public function getDiscountQty()
    {
        return parent::getDiscountQty();
    }

    public function getDiscountStep()
    {
        return parent::getDiscountStep();
    }

    public function getIsSimpleFreeShipping()
    {
        return parent::getSimpleFreeShipping();
    }

    public function getAppliesToShipping()
    {
        return parent::getApplyToShipping();
    }

    public function getTimesUsed()
    {
        return parent::getTimesUsed();
    }

    public function getIsRss()
    {
        return parent::getIsRss();
    }

    public function getWebsiteIds()
    {
        return parent::getWebsiteIds();
    }

    public function getCustomerGroupIds()
    {
        return parent::getCustomerGroupIds();
    }

}
