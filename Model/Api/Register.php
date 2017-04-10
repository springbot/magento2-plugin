<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\RegisterInterface;

/**
 * Class Register
 *
 * @package Springbot\Main\Model
 */
class Register implements RegisterInterface
{

    public function registerStores()
    {
        return $this;
    }


}
