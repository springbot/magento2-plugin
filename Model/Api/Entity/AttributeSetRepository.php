<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\AttributeSetRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\AttributeSetFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;


/**
 * Class AttributeSetRepository
 * @package Springbot\Main\Model\Api\Entity
 */
class AttributeSetRepository extends AbstractRepository implements AttributeSetRepositoryInterface
{

    private $attributeSetFactory;

    /**
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\App\ObjectManager $objectManager
     * @param \Springbot\Main\Model\Api\Entity\Data\AttributeSetFactory $factory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        ObjectManager $objectManager,
        AttributeSetFactory $factory
    )
    {
        $this->attributeSetFactory = $factory;
        parent::__construct($request, $resourceConnection, $objectManager);
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getList($storeId)
    {
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from(['eas' => $conn->getTableName('eav_attribute_set')])
            ->joinLeft(['eat' => $conn->getTableName('eav_entity_type')], 'eat.entity_type_id = eas.entity_type_id', ['eat.entity_type_code'])
            ->where('entity_type_code = ?', 'catalog_product')
            ->orWhere('entity_type_code = ?', 'catalog_category');
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
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from(['eas' => $conn->getTableName('eav_attribute_set')])
            ->joinLeft(['eat' => $conn->getTableName('eav_entity_type')], 'eat.entity_type_id = eas.entity_type_id', ['eat.entity_type_code'])
            ->where('attribute_set_id = ?', $attributeSetId);
        foreach ($conn->fetchAll($select) as $row) {
            if (in_array($row['entity_type_code'], ['catalog_product', 'catalog_category'])) {
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
        if ($row['entity_type_code'] == 'catalog_category') {
            $type = 'category';
        }
        else {
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
