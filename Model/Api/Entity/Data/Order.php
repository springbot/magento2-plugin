<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Framework\App\ObjectManager;
use Springbot\Main\Api\Entity\Data\OrderInterface;
use Springbot\Main\Model\Api\Entity\Data\Order\Item;
use Springbot\Main\Model\Api\Entity\Data\Order\ItemAttribute;
use Springbot\Main\Model\SpringbotOrderRedirect;
use Magento\Framework\Data\Collection;
use Magento\Sales\Model\Order as MagentoOrder;

/**
 * Class Order
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Order extends MagentoOrder implements OrderInterface
{

    public function getShipments()
    {
        return [];
    }

    public function getRedirectMongoId()
    {
        $orderRedirect = $this->getOrderRedirects()->getFirstItem();
        if (!$orderRedirect->isEmpty()) {
            return $orderRedirect->getData('redirect_string');
        } else {
            return null;
        }
    }

    public function getRedirectMongoIds()
    {
        $ret = array();
        foreach ($this->getOrderRedirects() as $redirectItem) {
            $ret[] = $redirectItem->getData('redirect_string');
        }
        return $ret;
    }

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemInterface[]
     */
    public function getItems()
    {
        $objectManager = ObjectManager::getInstance();
        $items = array();
        foreach (parent::getItems() as $item) {

            $product = $objectManager->get('Springbot\Main\Model\Api\Entity\Data\Product')->load($item->getProductId());
            $springbotItem = $objectManager->get('Springbot\Main\Model\Api\Entity\Data\Order\Item');
            /* @var \Springbot\Main\Model\Api\Entity\Data\Order\Item $springbotItem */

            $springbotItem->setSku($item->getSku());
            $springbotItem->setAttributeSetId($product->getAttributeSetId());
            $springbotItem->setDesc($product->getDescription());
            $springbotItem->setImageUrl($product->getImageUrl());
            $springbotItem->setCategoryIds($product->getCategoryIds());
            $springbotItem->setLandingUrl($product->getDefaultUrl());

            $productAttributes = [];
            foreach ($product->getCustomAttributes() as $customAttribute) {
                $productAttributes[] = new ItemAttribute(
                    $customAttribute->getAttributeCode(),
                    $customAttribute->getValue()
                );
            }
            $springbotItem->setProductAttributes($productAttributes);
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
    private function getOrderRedirects()
    {
        $objectManager = ObjectManager::getInstance();
        $orderRedirect = $objectManager->get('Springbot\Main\Model\SpringbotOrderRedirect');
        /* @var SpringbotOrderRedirect $orderRedirect */
        return $orderRedirect->getCollection()->addFieldToFilter('order_id', $this->getId())
            ->setOrder($orderRedirect->getIdFieldName(), 'DESC');
    }
}
