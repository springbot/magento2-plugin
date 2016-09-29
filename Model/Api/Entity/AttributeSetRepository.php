<?php

namespace Springbot\Main\Model\Api\Entity;

use Springbot\Main\Api\Entity\AttributeSetRepositoryInterface;

/**
 * Class AttributeSetRepository
 * @package Springbot\Main\Model\Api\Entity
 */
class AttributeSetRepository extends AbstractRepository implements AttributeSetRepositoryInterface
{

    /**
     * @param int $storeId
     * @return array
     */
    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $collection->addFieldToFilter('entity_type_id', ['in' => [1, 4]]);
        $this->filterResults($collection);

        $ret = [];
        foreach ($collection->getItems() as $item) {
            $ret[] = $this->getFromId($storeId, $item->getId());
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
     * @return mixed
     */
    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\AttributeSet');
    }
}
