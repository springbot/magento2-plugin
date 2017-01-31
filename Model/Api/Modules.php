<?php

namespace Springbot\Main\Model\Api;

use Magento\Backend\Service\V1\ModuleService;
use Springbot\Main\Api\ModulesInterface;

/**
 * Class Modules
 *
 * @package Springbot\Main\Model
 */
class Modules extends ModuleService implements ModulesInterface
{
    /**
     * @return array
     */
    public function getModules()
    {
        return $this->moduleList->getAll();
    }
}