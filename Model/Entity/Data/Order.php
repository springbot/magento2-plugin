<?php

namespace Springbot\Main\Model\Entity\Data;

use Magento\Framework\App\ObjectManager;
use Springbot\Main\Api\Entity\Data\OrderInterface;
use Springbot\Main\Model\Entity\Data\Order\Item;
use Springbot\Main\Model\Entity\Data\Order\ItemAttribute;
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
        $ret = array();
        foreach ($this->_getOrderRedirects() as $redirectItem) {
            $ret[] = $redirectItem->getData('redirect_string');
        }
        return $ret;
    }

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemInterface[]
     */
    public function getItems()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $items = array();
        foreach (parent::getItems() as $item) {

            $product = $objectManager->get('Springbot\Main\Model\Entity\Data\Product')->load($item->getProductId());
            $springbotItem = $objectManager->get('Springbot\Main\Model\Entity\Data\Order\Item');
            /* @var \Springbot\Main\Model\Entity\Data\Order\Item $springbotItem */

            $springbotItem->setSku($item->getSku());
            $springbotItem->setAttributeSetId($product->getAttributeSetId());
            $springbotItem->setDesc($product->getDescription());
            $springbotItem->setImageUrl($product->getImageUrl());
            $springbotItem->setCategoryIds($product->getCategoryIds());
            $springbotItem->setLandingUrl($product->getDefaultUrl());
            $springbotItem->setAttributes([
                new ItemAttribute('foo', 'bar')
            ]);

            $springbotItem->setProductType($item->getProductType());
            $springbotItem->setProductId($item->getProductId());
            $springbotItem->setName($item->getName());
            $springbotItem->setQtyOrdered($item->getQtyOrdered());
            $springbotItem->setSku($item->getSku());
            $springbotItem->setWgt($item->getWeight());
            $springbotItem->setSellPrice($item->getPrice());

            $items[] = $springbotItem;
        }
        return $items;
    }

    public function getTotalPaid()
    {
        return $this->getBaseTotalPaid();
    }

    /**
     * @return Collection
     */
    private function _getOrderRedirects()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderRedirect = $objectManager->get('Springbot\Main\Model\SpringbotOrderRedirect');
        /* @var SpringbotOrderRedirect $orderRedirect */
        return $orderRedirect->getCollection()->addFieldToFilter('order_id', $this->getId())
            ->setOrder($orderRedirect->getIdFieldName(), 'DESC');
    }
}
