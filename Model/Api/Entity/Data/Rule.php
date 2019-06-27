<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\SalesRule\Model\Rule as MagentoRule;
use Springbot\Main\Api\Entity\Data\RuleInterface;
use Magento\Framework\App\ProductMetadataInterface;

/**
 *  Rule
 * @package Springbot\Main\Api\Data
 */
class Rule implements RuleInterface
{
    public $storeId;
    public $ruleId;
    public $isActive;
    public $name;
    public $description;
    public $conditions;
    public $actions;
    public $fromDate;
    public $toDate;
    public $usesPerCoupon;
    public $usesPerCustomer;
    public $stopRulesProcessing;
    public $isAdvanced;
    public $productIds;
    public $sortOrder;
    public $simpleAction;
    public $discountAmount;
    public $discountQty;
    public $discountStep;
    public $isSimpleFreeShipping;
    public $appliesToShipping;
    public $timesUsed;
    public $isRss;

    private $connectionResource;
    private $productMetadata;

    /**
     * Inventory constructor.
     * @param \Magento\Framework\App\ResourceConnection $connectionResource
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(ResourceConnection $connectionResource, ProductMetadataInterface $productMetadata)
    {
        $this->connectionResource = $connectionResource;
        $this->productMetadata = $productMetadata;
    }

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
    ) {
        $this->storeId = $storeId;
        $this->ruleId = $ruleId;
        $this->isActive = $isActive;
        $this->name = $name;
        $this->description = $description;
        $this->conditions = $conditions;
        $this->actions = $actions;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->usesPerCoupon = $usesPerCoupon;
        $this->usesPerCustomer = $usesPerCustomer;
        $this->stopRulesProcessing = $stopRulesProcessing;
        $this->isAdvanced = $isAdvanced;
        $this->productIds = $productIds;
        $this->sortOrder = $sortOrder;
        $this->simpleAction = $simpleAction;
        $this->discountAmount = $discountAmount;
        $this->discountQty = $discountQty;
        $this->discountStep = $discountStep;
        $this->isSimpleFreeShipping = $isSimpleFreeShipping;
        $this->appliesToShipping = $appliesToShipping;
        $this->timesUsed = $timesUsed;
        $this->isRss = $isRss;
    }

    /**
     * @return mixed
     */
    public function getRuleId()
    {
        return $this->ruleId;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @return mixed
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return mixed
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @return mixed
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @return mixed
     */
    public function getUsesPerCoupon()
    {
        return $this->usesPerCoupon;
    }

    /**
     * @return mixed
     */
    public function getUsesPerCustomer()
    {
        return $this->usesPerCustomer;
    }

    /**
     * @return mixed
     */
    public function getStopRulesProcessing()
    {
        return $this->stopRulesProcessing;
    }

    /**
     * @return mixed
     */
    public function getIsAdvanced()
    {
        return $this->isAdvanced;
    }

    /**
     * @return mixed
     */
    public function getProductIds()
    {
        return $this->productIds;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return mixed
     */
    public function getSimpleAction()
    {
        return $this->simpleAction;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @return mixed
     */
    public function getDiscountQty()
    {
        return $this->discountQty;
    }

    /**
     * @return mixed
     */
    public function getDiscountStep()
    {
        return $this->discountStep;
    }

    /**
     * @return mixed
     */
    public function getIsSimpleFreeShipping()
    {
        return $this->isSimpleFreeShipping;
    }

    /**
     * @return mixed
     */
    public function getAppliesToShipping()
    {
        return $this->appliesToShipping;
    }

    /**
     * @return mixed
     */
    public function getTimesUsed()
    {
        return $this->timesUsed;
    }

    /**
     * @return mixed
     */
    public function getIsRss()
    {
        return $this->isRss;
    }


    /**
     * @return mixed
     */
    public function getCouponCodes()
    {
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('salesrule_coupon')])
            ->where('rule_id = ?', $this->ruleId);

        $coupons = [];
        foreach ($conn->fetchAll($select) as $row) {
            $coupons[] = $row['code'];
        }
        return $coupons;
    }

    /**
     * @return mixed
     */
    public function getWebsiteIds()
    {
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $idColumnName = $this->getIdColumnName();
        $select = $conn->select()
            ->from([$resource->getTableName('salesrule_website')])
            ->where($idColumnName . ' = ?', $this->ruleId);

        $websiteIds = [];
        foreach ($conn->fetchAll($select) as $row) {
            $websiteIds[] = $row['website_id'];
        }
        return $websiteIds;
    }

    /**
     * @return mixed
     */
    public function getCustomerGroupIds()
    {
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $idColumnName = $this->getIdColumnName();
        $select = $conn->select()
            ->from([$resource->getTableName('salesrule_customer_group')])
            ->where($idColumnName . ' = ?', $this->ruleId);

        $groupIds = [];
        foreach ($conn->fetchAll($select) as $row) {
            $groupIds[] = $row['customer_group_id'];
        }
        return $groupIds;
    }

    /**
     * @return string
     */
    private function getIdColumnName()
    {
        $version = $this->productMetadata->getVersion();
        $edition = $this->productMetadata->getEdition();

        if ((in_array($edition, ['Enterprise', 'B2B'])) && version_compare($version, '2.1', '>=')) {
            return 'row_id';
        } else {
            return 'rule_id';
        }
    }
}
