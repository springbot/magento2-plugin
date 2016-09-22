<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Api\Entity\Data\CartInterface;
use Springbot\Main\Model\Entity\Data\Cart\Item;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote;
/**
 * Class Cart
 * @package Springbot\Main\Model\Entity\Data
 */
class Cart extends Quote implements CartInterface
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

    public function getCustomerId()
    {
        return 9999;
    }


    public function getCustomerPrefix()
    {
        return 'MRRR';
    }


    public function getCustomerLastname()
    {
        return 'MRRR';
    }

    public function getCustomerMiddlename()
    {
        return 'MRRR';
    }

    public function getCustomerFirstname()
    {
        return 'MRRR';
    }

    public function getCustomerSuffix()
    {
        return 'The 3rd';
    }

    public function getRemoteIp()
    {
        return '127.0.0.1';
    }

    public function getCartUserAgent()
    {
        return 'XXX';
    }


    public function getCustomerEmail()
    {
        return 'x' . parent::getCustomerEmail();
    }


}
