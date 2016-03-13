<?php

namespace Springbot\Main\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class Async
 *
 * @package Springbot\Main\Block
 */
class Async extends Template
{
    /**
     * @var SpringbotHelper
     */
    private $_springbotHelper;

    /**
     * @param Context $context
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        Context $context,
        SpringbotHelper $springbotHelper
    ) {
        $this->_springbotHelper = $springbotHelper;
        parent::__construct($context);
    }

    /**
     * Default domain that serves our JS script
     *
     * @return string
     */
    public function getAssetsDomain()
    {
        return 'd2z0bn1jv8xwtk.cloudflare.com';
    }

    /**
     * Get the GUID for the async code
     *
     * @return string
     */
    public function getStoreGuid()
    {
        return strtolower($this->_springbotHelper->getStoreGuid());
    }
}
