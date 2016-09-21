<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Model\Entity\Data\Cart\Item;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote;
/**
 * Class Cart
 * @package Springbot\Main\Model\Entity\Data
 */
class Cart extends Quote
{


    public function getItems()
    {
        $objectManager = ObjectManager::getInstance();
        $items = array();
        foreach (parent::getAllVisibleItems() as $item) {
            $product = $objectManager->get('Springbot\Main\Model\Entity\Data\Product')->load($item->getProductId());
            $springbotItem = $objectManager->get('Springbot\Main\Model\Entity\Data\Cart\Item');
            /* @var Item $springbotItem */

            $springbotItem->setSku($item->getSku());
            $springbotItem->setImageUrl($product->getImageUrl());
            $springbotItem->setLandingUrl($product->getDefaultUrl());
            $springbotItem->setProductType($item->getProductType());
            $springbotItem->setQtyOrdered($item->getQtyOrdered());

            $items[] = $springbotItem;
        }
        return $items;

    }

}
