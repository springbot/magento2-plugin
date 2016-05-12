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

    abstract public function handle($storeId, $productId);
    abstract public function handleDelete($storeId, $productId);

    public function __construct(
        StoreConfiguration $storeConfig,
        State $state,
        Api $api,
        Context $context,
        Registry $registry
    ) {
        $this->state = $state;
        $this->objectManager = ObjectManager::getInstance();
        $this->storeConfig = $storeConfig;
        $this->api = $api;

        $this->state->setAreaCode("adminhtml");
        parent::__construct($context, $registry);
    }
}
