<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\Entity\CartRepositoryInterface;

/**
 * Class CartRepository
 * @package Springbot\Main\Model\Entity
 */
class CartRepository extends AbstractRepository implements CartRepositoryInterface
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
        foreach ($collection as $cart) {
            $ret[] = $this->getSpringbotModel()->load($cart->getId());
        }
        return $ret;
    }

    /**
     * @param int $storeId
     * @param int $cartId
     * @return $this
     */
    public function getFromId($storeId, $cartId)
    {
        return $this->getSpringbotModel()->load($cartId);
    }

    /**
     * @return mixed
     */
    public function getSpringbotModel()
    {
        return $this->objectManager->create('Springbot\Main\Model\Entity\Data\Cart');
    }



}
