<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\AttributeSetRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\AttributeSetFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;

/**
 * Class AttributeSetRepository
 *
 * @package Springbot\Main\Model\Api\Entity
 */
class AttributeSetRepository extends AbstractRepository implements AttributeSetRepositoryInterface
{
    private $attributeSetFactory;

    /**
     * @param \Magento\Framework\App\Request\Http                       $request
     * @param \Magento\Framework\App\ResourceConnection                 $resourceConnection
     * @param \Springbot\Main\Model\Api\Entity\Data\AttributeSetFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        AttributeSetFactory $factory
    ) {

        $this->attributeSetFactory = $factory;
        parent::__construct($request, $resourceConnection);
    }

    /**
     * @param int $storeId
     * @return string[]
     */
    public function getList($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['eas' => $resource->getTableName('eav_attribute_set')])
            ->joinLeft(['eat' => $resource->getTableName('eav_entity_type')], 'eat.entity_type_id = eas.entity_type_id', ['eat.entity_type_code'])
            ->where('entity_type_code = ?', 'customer')
            ->orWhere('entity_type_code = ?', 'catalog_product');
        $this->filterResults($select);
        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $ret[] = $this->createAttributeSet($storeId, $row);
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $attributeSetId
     * @return $this
     */
    public function getFromId($storeId, $attributeSetId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['eas' => $resource->getTableName('eav_attribute_set')])
            ->joinLeft(['eat' => $resource->getTableName('eav_entity_type')], 'eat.entity_type_id = eas.entity_type_id', ['eat.entity_type_code'])
            ->where('attribute_set_id = ?', $attributeSetId);
        foreach ($conn->fetchAll($select) as $row) {
            if (in_array($row['entity_type_code'], ['catalog_product', 'customer'])) {
                return $this->createAttributeSet($storeId, $row);
            }
        }
        return null;
    }

    /**
     * @param $storeId
     * @param $row
     * @return mixed
     */
    public function createAttributeSet($storeId, $row)
    {
        $attributeSet = $this->attributeSetFactory->create();
        if ($row['entity_type_code'] == 'customer') {
            $type = 'customer';
        } else {
            $type = 'product';
        }
        $attributeSet->setValues(
            $storeId,
            $row['attribute_set_id'],
            $row['attribute_set_name'],
            $type
        );
        return $attributeSet;
    }
}
