<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
use Springbot\Main\Model\StoreConfiguration;

/**
 * Class AbstractHandler
 *
 * Handlers are classes intended to be run from the job queue. They are responsible for loading a given entity based
 * on its id and sending it to the Springbot API.
 *
 * @package Springbot\Main\Model\Handler
 */
abstract class AbstractHandler
{

    const data_source_bh = 'BH';
    const data_source_ob = 'OB';

    protected $storeConfig;
    protected $api;

    /**
     * @param int $storeId
     * @param int $id
     */
    abstract public function handle($storeId, $id);

    /**
     * @param int $storeId
     * @param int $id
     */
    abstract public function handleDelete($storeId, $id);

    /**
     * Handler constructor.
     *
     * @param StoreConfiguration $storeConfig
     * @param Api                $api
     */
    public function __construct(StoreConfiguration $storeConfig, Api $api)
    {
        $this->storeConfig = $storeConfig;
        $this->api = $api;
    }
}
