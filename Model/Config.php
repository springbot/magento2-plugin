<?php

namespace Springbot\Main\Model;

use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\ConfigInterface;

/**
 * Class Config
 * @package Springbot\Main\Api
 */
class Config extends AbstractModel implements ConfigInterface
{

    private $_scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        Registry $registry
    ) {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $registry);
    }

    public function getConfig()
    {
        return $this->_scopeConfig->getValue('springbot');
    }

}
