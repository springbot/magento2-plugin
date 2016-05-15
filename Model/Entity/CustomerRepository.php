<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\CustomerRepositoryInterface;

/**
 *  CustomerRepository
 * @package Springbot\Main\Api
 */
class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $array = $collection->toArray();
        return $array['items'];
    }

    public function getFromId($storeId, $customerId)
    {
        return $this->getSpringbotModel()->load($customerId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Customer');
    }


}
