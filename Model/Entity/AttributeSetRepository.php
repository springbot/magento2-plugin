<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\Entity\AttributeSetRepositoryInterface;

/**
 * Class AttributeSetRepository
 * @package Springbot\Main\Model\Entity
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
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\AttributeSet');
    }
}
