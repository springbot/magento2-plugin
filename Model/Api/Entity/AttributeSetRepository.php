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
            ->from([$conn->getTableName('eav_attribute_set')]);
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
        return $this->getSpringbotModel()->load($attributeSetId);
    }

    /**
     * @param $storeId
     * @param $row
     * @return mixed
     */
    public function createAttributeSet($storeId, $row)
    {
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setValues(
            $storeId,
            $row['attribute_set_id'],
            $row['attribute_set_name'],
            $row['entity_type_id']
        );
        return $attributeSet;
    }
}
