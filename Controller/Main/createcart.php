<?php

namespace Springbot\Main\Controller\Main;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Springbot\Main\Controller
 */
class createCart extends Action
{
    private $cart;
    private $context;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Checkout\Model\Cart $cart
     */   
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Cart $cart)
    {
        $this->context = $context;
        $this->cart = $cart;
        parent::__construct($context);
    }
 
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            if (empty($this->cart->getQuote()->getID())) {
                $this->cart->save();
            }
            $out = ["cart_id" => $this->cart->getQuote()->getID()];
        } catch (\Exception $e) {
            $out = ["error" => "Failed to generate new cart: {$e->getMessage()}"];
        } 
        
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($out);
        return $resultJson;
    }
}
