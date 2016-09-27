<?php

namespace Springbot\Main\Api\Entity;

/**
 * Interface OrderRepositoryInterface
 * @package Springbot\Main\Api
 */
interface OrderRepositoryInterface
{
    /**
     * @param int $storeId
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface[]
     */
    public function getList($storeId);

    /**
     * @param int $storeId
     * @param int $orderId
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface
     */
    public function getFromId($storeId, $orderId);

    /**
     * @param int $storeId
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @param \Magento\Quote\Api\Data\CartItemInterface[] $items
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface
     */
    public function create($storeId, $customer, $address, $quote, $items);
}
