<?php

namespace Springbot\Main\Model\Entity\Data;

use Magento\Sales\Model\Order as MagentoOrder;

/**
 *  Guest
 *
 * Springbot "guests" are customers for which there is no customer record. Since they have no customer record, we
 * determine guests from the order objects.
 *
 * @package Springbot\Main\Api\Data
 */
class Guest extends MagentoOrder
{
}
