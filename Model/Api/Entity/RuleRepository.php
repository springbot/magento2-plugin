<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Request\Http;
use Springbot\Main\Api\Entity\RuleRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\RuleFactory;

/**
 *  RuleRepository
 *
 * @package Springbot\Main\Api
 */
class RuleRepository extends AbstractRepository implements RuleRepositoryInterface
{
    private $ruleFactory;

    /**
     * RuleRepository constructor.
     *
     * @param \Magento\Framework\App\Request\Http               $request
     * @param \Magento\Framework\App\ResourceConnection         $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\RuleFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        RuleFactory $factory
    ) {

        $this->ruleFactory = $factory;
        parent::__construct($request, $resourceConnection);
    }

    public function getList($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('salesrule')]);
        $this->filterResults($select);

        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createProduct($storeId, $row);
        }
        return $ret;
    }

    public function getFromId($storeId, $ruleId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('salesrule')])
            ->where('rule_id = ?', $ruleId);
        foreach ($conn->fetchAll($select) as $row) {
            return $this->createProduct($storeId, $row);
        }
        return null;
    }


    private function createProduct($storeId, $row)
    {
        $rule = $this->ruleFactory->create();
        $rule->setValues(
            $storeId,
            $row['rule_id'],
            $row['is_active'],
            $row['name'],
            $row['description'],
            $row['conditions_serialized'],
            $row['actions_serialized'],
            $row['from_date'],
            $row['to_date'],
            $row['uses_per_coupon'],
            $row['uses_per_customer'],
            $row['stop_rules_processing'],
            $row['is_advanced'],
            $row['product_ids'],
            $row['sort_order'],
            $row['simple_action'],
            $row['discount_amount'],
            $row['discount_qty'],
            $row['discount_step'],
            $row['simple_free_shipping'],
            $row['apply_to_shipping'],
            $row['times_used'],
            $row['is_rss']
        );
        return $rule;
    }
}
