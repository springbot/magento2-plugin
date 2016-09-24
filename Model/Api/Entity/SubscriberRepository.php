<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\SubscriberRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 * SubscriberRepository
 * @package Springbot\Main\Api
 */
class SubscriberRepository extends AbstractRepository implements SubscriberRepositoryInterface
{

    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\SubscriberInterface[]
     */
    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $collection->addFieldToFilter('store_id', $storeId);
        $this->filterResults($collection);
        $rules = $collection->toArray();
        return $rules['items'];
    }

    /**
     * @param int $storeId
     * @param int $subscriberId
     * @return \Springbot\Main\Api\Entity\Data\SubscriberInterface
     */
    public function getFromId($storeId, $subscriberId)
    {
        return $this->getSpringbotModel()->load($subscriberId);
    }

    /**
     * @return mixed
     */
    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Subscriber');
    }
}
