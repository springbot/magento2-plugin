<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\ModulesInterface;

/**
 * Class Modules
 *
 * @package Springbot\Main\Model
 */
class Modules extends AbstractModel implements ModulesInterface
{
    /**
     * Returns a list of all modules with setup version number
     *
     * @return array
     */
    public function getModules()
    {

    }
}