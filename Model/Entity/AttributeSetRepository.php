<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\AttributeSetRepositoryInterface;
use Springbot\Main\Model\Entity\Data\AttributeSet;

/**
 *  AttributeSetRepository
 * @package Springbot\Main\Api
 */
class AttributeSetRepository extends AbstractRepository implements AttributeSetRepositoryInterface
{

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

    public function getFromId($storeId, $attributeSetId)
    {
        return $this->getSpringbotModel()->load($attributeSetId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\AttributeSet');
    }


}
