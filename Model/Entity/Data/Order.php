<?php

namespace Springbot\Main\Model\Entity\Data;

use Magento\Framework\App\ObjectManager;
use Springbot\Main\Api\Entity\Data\OrderInterface;
use Springbot\Main\Model\SpringbotOrderRedirect;
use Magento\Framework\Data\Collection;

/**
 * Class Order
 * @package Springbot\Main\Model\Entity\Data
 */
class Order extends \Magento\Sales\Model\Order implements OrderInterface
{

    public function getRedirectMongoId()
    {
        $orderRedirect = $this->_getOrderRedirects()->getFirstItem();
        if (!$orderRedirect->isEmpty()) {
            return $orderRedirect->getData('redirect_string');
        } else {
            return null;
        }
    }

    public function getRedirectMongoIds()
    {
        $ret = [];
        foreach ($this->_getOrderRedirects() as $redirectItem) {
            $ret[] = $redirectItem->getData('redirect_string');
        }
        return $ret;
    }

    public function getLineItems()
    {
        $items = array();
        foreach ($this->getAllVisibleItems() as $item) {
            $items[] = $item->toArray();
        }
        return $items;
    }

    /**
     * @return Collection
     */
    private function _getOrderRedirects()
    {
        $objectManager = ObjectManager::getInstance();
        $orderRedirect = $objectManager->get('Springbot\Main\Model\SpringbotOrderRedirect');
        /* @var SpringbotOrderRedirect $orderRedirect */
        return $orderRedirect->getCollection()->addFieldToFilter('order_id', $this->getId())
            ->setOrder($orderRedirect->getIdFieldName(), 'DESC');
    }
}
