<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\RegisterStoresInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Springbot\Main\Model\RegisterFactory;

/**
 * Class RegisterStores
 *
 * @package Springbot\Main\Model
 */
class RegisterStores implements RegisterStoresInterface
{
    private $registerFactory;
    private $scopeConfig;

    /**
     * Register constructor.
     * @param RegisterFactory $registerFactory
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        RegisterFactory $registerFactory,
        ScopeConfigInterface $scopeConfigInterface
    ) {
        $this->registerFactory = $registerFactory;
        $this->scopeConfig = $scopeConfigInterface;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function registerStores()
    {
        $registerModel = $this->registerFactory->create();
        $apiToken = $this->scopeConfig->getValue('springbot/configuration/security_token');

        if (! $apiToken) {
            throw new \Exception("Could not register stores, security token not set");
        }

        // Call the registerAllStores() method authenticating by apiToken instead of username/password
        $registerModel->registerAllStores(null, null, $apiToken);

        return $this;
    }
}
