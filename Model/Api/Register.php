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
    private $registerFactory;

    /**
     * @param RegisterFactory $registerFactory
     */
    public function __construct(RegisterFactory $registerFactory)
    {
        $this->registerFactory = $registerFactory;
    }

    public function registerStores()
    {
        $registerModel = $this->registerFactory->create();

        // TODO: Register model needs to split out so authenticate and register are two separate methods

        return $this;
    }

}
