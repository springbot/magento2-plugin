<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\SubscriberRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 *  SubscriberRepository
 * @package Springbot\Main\Api
 */
class SubscriberRepository extends AbstractRepository implements SubscriberRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $rules = $collection->toArray();
        return $rules['items'];
    }

    /**
     * @param int $storeId
     * @param int $subscriberId
     * @return \Springbot\Main\Model\Entity\Data\Subscriber
     */
    public function getFromId($storeId, $subscriberId)
    {
        return $this->getSpringbotModel()->load($subscriberId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Subscriber');
    }
}
