<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\CartInterface;
use Springbot\Main\Model\Api\Entity\Data\Cart\Item;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote;
/**
 * Class Cart
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Cart extends Quote implements CartInterface
{

    public function getItems()
    {
        $objectManager = ObjectManager::getInstance();
        $items = array();
        foreach (parent::getAllVisibleItems() as $item) {
            $product = $objectManager->get('Springbot\Main\Model\Api\Entity\Data\Product')->load($item->getProductId());
            $springbotItem = $objectManager->get('Springbot\Main\Model\Api\Entity\Data\Cart\Item');
            /* @var Item $springbotItem */

            $springbotItem->setSku($item->getSku());
            $springbotItem->setImageUrl($product->getImageUrl());
            $springbotItem->setLandingUrl($product->getDefaultUrl());
            $springbotItem->setProductType($item->getProductType());
            $springbotItem->setQtyOrdered($item->getQty());
            $items[] = $springbotItem;
        }
        return $items;
    }

    public function getCustomerId()
    {
        return parent::getCustomerId();
    }

    public function getCustomerPrefix()
    {
        return parent::getCustomerPrefix();
    }

    public function getCustomerLastname()
    {
        return parent::getCustomerLastname();
    }

    public function getCustomerMiddlename()
    {
        return parent::getCustomerMiddlename();
    }

    public function getCustomerFirstname()
    {
        return parent::getCustomerFirstname();
    }

    public function getCustomerSuffix()
    {
        return parent::getCustomerSuffix();
    }

    public function getRemoteIp()
    {
        return parent::getRemoteIp();
    }

    public function getCartUserAgent()
    {
        return null;
    }

    public function getCustomerEmail()
    {
        return parent::getCustomerEmail();
    }

}
