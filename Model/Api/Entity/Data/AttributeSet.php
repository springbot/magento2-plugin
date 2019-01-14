<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Eav\Model\Entity\Attribute\Set as MagentoAttributeSet;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;
use Springbot\Main\Api\Entity\Data\AttributeSetInterface;
use Springbot\Main\Model\Api\Entity\Data\AttributeSet\AttributeSetAttribute;
use Springbot\Main\Model\Api\Entity\Data\AttributeSet\AttributeSetAttributeFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * Class AttributeSet
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class AttributeSet implements AttributeSetInterface
{

    public $storeId;
    public $attributeSetId;
    public $name;
    public $type;

    protected $resourceConnection;
    private $attributeFactory;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param AttributeSetAttributeFactory $attributeFactory
     */
    public function __construct(ResourceConnection $resourceConnection, AttributeSetAttributeFactory $attributeFactory)
    {
        $this->resourceConnection = $resourceConnection;
        $this->attributeFactory = $attributeFactory;
    }


    /**
     * @param $storeId
     * @param $attributeSetId
     * @param $name
     * @param $type
     * @return void
     */
    public function setValues($storeId, $attributeSetId, $name, $type)
    {
        $this->storeId = $storeId;
        $this->attributeSetId = $attributeSetId;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \Springbot\Main\Api\Entity\Data\AttributeSet\AttributeSetAttributeInterface[]
     */
    public function getAttributes()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $query = $conn->query("SELECT * FROM {$resource->getTableName('eav_entity_attribute')} eaa
            LEFT JOIN {$resource->getTableName('eav_attribute')} ea
                ON (ea.attribute_id = eaa.attribute_id)
            WHERE eaa.attribute_set_id = :attribute_set_id
        ", ['attribute_set_id' => $this->getAttributeSetId()]);

        $attributes = [];
        foreach ($query->fetchAll() as $row) {
            if($row['attribute_code'] == "group_id") {
                $attribute = $this->attributeFactory->create();
                $attribute->setValues(
                    $row['attribute_id'],
                    $row['frontend_label'],
                    $row['attribute_code'],
                    $this->getCustomerGroupNames()
                );
            } else {
                $optionQuery = $conn->query("SELECT * FROM {$resource->getTableName('eav_attribute_option')} eao
                    LEFT JOIN {$resource->getTableName('eav_attribute_option_value')} eaov
                        ON (eao.option_id = eaov.option_id)
                    WHERE eao.attribute_id = :attribute_id
                ", ['attribute_id' => $row['attribute_id']]);

                $options = [];
                foreach ($optionQuery->fetchAll() as $optionRow) {
                    $options[] = $optionRow['value'];
                }

                $attribute = $this->attributeFactory->create();
                $attribute->setValues(
                    $row['attribute_id'],
                    $row['frontend_label'],
                    $row['attribute_code'],
                    $options
                );
            }
            $attributes[] = $attribute;
        }
        return $attributes;
    }

    /**
     * @return mixed
     */
    public function getCustomerGroupNames()
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from([$resource->getTableName('customer_group')]);
        $groupNames = [];
        foreach ($conn->fetchAll($select) as $row) {
            $groupNames[] = $row['customer_group_code'];
        }
        return $groupNames;
    }
}
