<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\CreateCartInterface;

/**
 * Class Log
 *
 * @package Springbot\Main\Api
 */
class CreateCart extends AbstractModel implements CreateCartInterface
{
    /**
     * Looks for or creates a user Cart on demmand.
     */
    public function getCart()
    {
        return "works";
    }
}
