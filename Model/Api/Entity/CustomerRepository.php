<?php

namespace Springbot\Main\Model\Api\Entity;

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
        $collection->addFieldtoFilter('store_id', $storeId);
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection->getAllIds() as $id) {
            $ret[] = $this->getFromId($storeId, $id);
        }
        return $ret;
    }

    public function getFromId($storeId, $customerId)
    {
        return $this->getSpringbotModel()->load($customerId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Api\Entity\Data\Customer');
    }
}
