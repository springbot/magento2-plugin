<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Config\Model\ResourceModel\Config;
use Springbot\Main\Model\Register;
use Psr\Log\LoggerInterface;
use Springbot\Main\Model\Api;

/**
 * Class Login
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Login extends Action
{
    private $_config;
    private $_register;
    private $_logger;
    private $_resultPageFactory;
    private $_api;

    /**
     * @return Config
     */
    public function config()
    {
        $this->_config;
    }

    /**
     * @return Register
     */
    public function register()
    {
        return $this->_register;
    }

    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function getResultPageFactory()
    {
        return $this->_resultPageFactory;
    }

    /**
     * Login constructor.
     * @param Config $config
     * @param Context $context
     * @param LoggerInterface $logger
     * @param PageFactory $pageFactory
     * @param Register $register
     * @param Api $api
     */
    public function __construct(
        Config $config,
        Context $context,
        LoggerInterface $logger,
        PageFactory $pageFactory,
        Register $register,
        Api $api
    )
    {
        $this->_logger = $logger;
        $this->_config = $config;
        $this->_resultPageFactory = $pageFactory;
        $this->_register = $register;
        $this->_api = $api;
        parent::__construct($context);
    }

    /**
     * Page execute
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        // Pull values from the customer form for transit back to Springbot
        $springbotEmail = $this->getRequest()->getParam('springbot-email');
        $springbotPassword = $this->getRequest()->getParam('springbot-password');
        $registered = $this->register()->registerAllStores($springbotEmail, $springbotPassword);

        if ($registered) {
            return $this->_redirect($this->_api->getAppUrl());
            /*
            $resultPage = $this->getResultPageFactory()->create();
            $resultPage->setActiveMenu('Springbot_Main::main');
            $resultPage->addBreadcrumb(__('Springbot'), __('Springbot'));
            $resultPage->getConfig()->getTitle()->prepend(__('Springbot'));
            return $resultPage;
            */
        }
        else {
            // If response comes back 'unauthorized', redirect to the index page.
            $this->_redirect('*/dashboard', ['unauthorized']);
        }
    }
}
