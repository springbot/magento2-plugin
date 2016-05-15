<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\CartRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 *  CartRepository
 * @package Springbot\Main\Api
 */
class CartRepository extends AbstractRepository implements CartRepositoryInterface
{

    public function getList($storeId)
    {
        $collection = $this->getSpringbotModel()->getCollection();
        $this->filterResults($collection);
        $array = $collection->toArray();
        return $array['items'];
    }

    public function getFromId($storeId, $cartId)
    {
        return $this->getSpringbotModel()->load($cartId);
    }

    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Cart');
    }
}
