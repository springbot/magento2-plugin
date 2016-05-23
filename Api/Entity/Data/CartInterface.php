<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CartInterface
 * @package Springbot\Main\Api\Entity\Data
 */
interface CartInterface extends \Magento\Quote\Api\Data\CartInterface
{
    /**
     * @return \Magento\Quote\Api\Data\CartItemInterface[]
     */
    public function getAllVisibleItems();
}
