<?php

namespace Springbot\Main\Model\Entity\Data;

/**
 * Class Cart
 * @package Springbot\Main\Model\Entity\Data
 */
class Cart extends \Magento\Quote\Model\Quote
{

    /**
     * @return array
     */
    public function getItems()
    {
        $items = array();
        foreach ($this->getAllVisibleItems() as $item) {
            $items[] = $item->toArray();
        }
        return $items;
    }

}
