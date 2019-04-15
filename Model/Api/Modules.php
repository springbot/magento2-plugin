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
     * @return string[]
     */
    public function getModules()
    {
        return $this->moduleList->getAll();
    }
    /**
     * @return string[]
     */
    public function getVersion()
    {
        $mainVersion = '';
        $queueVersion = '';
        $modules = $this->moduleList->getAll();
        foreach ($modules as $module) {
            if ($module['name'] == "Springbot_Main") {
                $mainVersion = $module['setup_version'];
            }
            if ($module['name'] == "Springbot_Queue") {
                $queueVersion = $module['setup_version'];
            }
        }
        // Magento wont return the full array with name and index unless you wrap it in... another array
        $out = [
            [
                "main" => $mainVersion,
                "queue" => $queueVersion
            ]
        ];
        return $out;
    }
}
