<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Api\Entity\Data\GuestInterface;

/**
 *  Guest
 *
 * Springbot "guests" are customers for which there is no customer record. Since they have no customer record, we
 * determine guests from the order objects.
 *
 * @package Springbot\Main\Api\Data
 */
class Guest extends MagentoOrder implements GuestInterface
{
    private static $offset = 100000000;

    public function getGuestId()
    {
        return parent::getEntityId() + self::$offset;
    }

    public function getOrderId()
    {
        return parent::getEntityId();
    }

    public function getFirstname()
    {
        return parent::getCustomerFirstname();
    }

    public function getLastname()
    {
        return parent::getCustomerLastname();
    }

    public function getEmail()
    {
        return parent::getCustomerEmail();
    }

    public function getBillingAddress()
    {
        // TODO: Implement getBillingAddress() method.
    }

    public function getShippingAddress()
    {
        // TODO: Implement getShippingAddress() method.
    }

}
