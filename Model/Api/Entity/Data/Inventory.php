<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\InventoryInterface;
use Magento\CatalogInventory\Model\Stock\Item as MagentoStockItem;
use Magento\Framework\App\ObjectManager;

/**
 * Class Inventory
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Inventory extends MagentoStockItem implements InventoryInterface
{
    public function getProductId()
    {
        return parent::getProductId();
    }

    public function getSystemManaged()
    {
        return parent::getManageStock();
    }

    public function getOutOfStockQty()
    {
        return parent::getMinQty();
    }

    public function getQuantity()
    {
        return parent::getQty();
    }

    public function getItemId()
    {
        return parent::getItemId();
    }

    public function getIsInStock()
    {
        return parent::getIsInStock();
    }

    public function getMinSaleQty()
    {
        return parent::getMinSaleQty();
    }

    public function getParentSkus()
    {
        $om = ObjectManager::getInstance();
        if ($product = $om->get('Springbot\Main\Model\Api\Entity\Data\Product')->load($this->getProductId())) {
            return $product->getParentSkus();
        }
        else {
            return [];
        }
    }

    public function getSkuFulfillment()
    {
        $om = ObjectManager::getInstance();
        if ($product = $om->get('Springbot\Main\Model\Api\Entity\Data\Product')->load($this->getProductId())) {
            return $product->getSku();
        }
        else {
            return null;
        }
    }

}
