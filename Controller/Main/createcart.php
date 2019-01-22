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
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(["out" => "working"]);
        return $resultJson;
    }
}
