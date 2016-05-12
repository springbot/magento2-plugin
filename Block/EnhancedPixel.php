<?php

namespace Springbot\Main\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Block\Success;
use Springbot\Main\Helper\Data as SpringbotHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\Order;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class EnhancedPixel extends Success
{

    /**
     * @param Context $context
     * @param OrderFactory $orderFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        ScopeConfigInterface $scopeConfig,
        SpringbotHelper $springbotHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->springbotHelper = $springbotHelper;
        parent::__construct($context, $orderFactory);
    }

    /**
     * @return float
     */
    public function getConversionValueInDollars()
    {
        $order = ObjectManager::getInstance()->get('Magento\Sales\Model\Order');
        /* @var Order $order */
        $order->load($this->getRealOrderId());
        return $order->getGrandTotal();
    }
}
