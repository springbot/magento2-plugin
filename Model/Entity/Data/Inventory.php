<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Api\Entity\Data\InventoryInterface;
use Magento\CatalogInventory\Model\Stock\Item as MagentoStockItem;

/**
 * Class Inventory
 * @package Springbot\Main\Model\Entity\Data
 */
class Inventory extends MagentoStockItem implements InventoryInterface
{
}
