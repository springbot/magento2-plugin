<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface GuestInterface
 *
 * Springbot "guests" are customers for which there is no customer record. Since they have no customer record, we
 * determine guests from the order objects.
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface GuestInterface extends \Magento\Sales\Api\Data\OrderInterface
{
}
