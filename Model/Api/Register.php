<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\RegisterInterface;
use Magento\Framework\App\Cache\Manager;

/**
 * Class Register
 *
 * @package Springbot\Main\Model
 */
class Register implements RegisterInterface
{
    private $registerFactory;
    private $cacheManager;

    /**
     * Register constructor.
     * @param RegisterFactory $registerFactory
     * @param Manager $cacheManager
     */
    public function __construct(
        RegisterFactory $registerFactory,
        Manager $cacheManager
    ) {
        $this->registerFactory = $registerFactory;
        $this->cacheManager = $cacheManager;
    }

    public function registerStores()
    {
        $registerModel = $this->registerFactory->create();

        // TODO: Register model needs to split out so authenticate and register are two separate methods

        return $this;
    }

}
