<?php

namespace Springbot\Main\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\State;

/**
 * Class Handler
 *
 * Handlers are classes intended to be run from the job queue. They are responsible for loading a given entity based
 * on its id and sending it to the Springbot API.
 *
 * @package Springbot\Main\Model
 */
abstract class Handler extends AbstractModel
{

    const DATA_SOURCE_BH = 'BH';
    const DATA_SOURCE_OB = 'OB';

    protected $storeConfig;
    protected $state;
    protected $objectManager;
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
     * @param StoreConfiguration $storeConfig
     * @param Api $api
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        StoreConfiguration $storeConfig,
        Api $api,
        Context $context,
        Registry $registry
    )
    {
        $this->state = $context->getAppState();
        $this->objectManager = ObjectManager::getInstance();
        $this->storeConfig = $storeConfig;
        $this->api = $api;
        parent::__construct($context, $registry);
    }
}
