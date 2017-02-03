<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\ConfigInterface;
use Magento\Config\Model\ResourceModel\Config as ConfigResource;

/**
 * Class Config
 *
 * @package Springbot\Main\Api
 */
class Config extends AbstractModel implements ConfigInterface
{

    private $scopeConfig;
    private $configResource;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Context              $context
     * @param Registry             $registry
     * @param ConfigResource       $configResource
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        Registry $registry,
        ConfigResource $configResource
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configResource = $configResource;
        parent::__construct($context, $registry);
    }

    public function getConfig()
    {
        $ret = [];
        foreach ($this->scopeConfig->getValue('springbot') as $section => $values) {
            foreach ($values as $key => $value) {
                $ret[] = new ConfigItem("springbot/{$section}/{$key}", $value);
            }
        }
        return $ret;
    }

    public function saveConfig($path, $value)
    {
        if (substr($path, 0, strlen('springbot/')) !== 'springbot/') {
            throw new \Exception("Config path must be in springbot namespace");
        } elseif (substr_count($path, '/') !== 2) {
            throw new \Exception("Path must consist of 3 parts");
        } else {
            $this->configResource->saveConfig($path, $value, 'default', 0);
        }
        return $this;
    }
}
