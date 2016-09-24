<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\RuleRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\SalesRule\Model\Rule;

/**
 *  RuleRepository
 * @package Springbot\Main\Api
 */
class RuleRepository extends AbstractRepository implements RuleRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $rules = $collection->toArray();
        return $rules['items'];
    }

    public function getFromId($storeId, $ruleId)
    {
        return $this->getSpringbotModel()->load($ruleId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Rule');
    }
}
