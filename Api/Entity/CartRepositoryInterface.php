<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface CartRepositoryInterface
 * @package Springbot\Main\Api
 */
interface CartRepositoryInterface
{
    /**
     * Get store configuration
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\CartInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $cartId
     * @return \Springbot\Main\Api\Entity\Data\CartInterface
     */
    public function getFromId($storeId, $cartId);

    /**
     * @param int $cartId
     * @param \Magento\Quote\Api\Data\AddressInterface $address
     * @return \Springbot\Main\Api\Entity\Data\CartInterface
     */
    public function assignShipping($cartId, \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignments);
}
