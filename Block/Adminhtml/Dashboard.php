<?php

namespace Springbot\Main\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

/**
 * Class Main
 *
 * @package Springbot\Main\Block\Adminhtml
 */
class Dashboard extends Template
{
    /**
     * Main constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
