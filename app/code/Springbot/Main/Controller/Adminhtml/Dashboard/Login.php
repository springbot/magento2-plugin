<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Config\Model\ResourceModel\Config;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class Login
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Login extends Action
{
    /**
     * @var Config
     */
    private $_config;

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param Config $config
     * @param Context $context
     */
    public function __construct(
        Config $config,
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->_config = $config;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Page execution
     */
    public function execute()
    {
        /**
         * Pull values from the customer form for transit back to Springbot
         */
        $springbotEmail = $this->getRequest()->getParam('springbot-email');
        $springbotPassword = $this->getRequest()->getParam('springbot-password');
        $url = SpringbotHelper::SPRINGBOT_REGISTRATION_URL;

        /**
         * Send the params to the Springbot API and get an API token
         */
        try {
            $client = new \Zend_Http_Client($url);
            $client->setRawData('{"user_id":"' . $springbotEmail . '", "password":"' . $springbotPassword . '"}');
            $client->setHeaders('Content-Type: application/json');
            $response = $client->request('POST');
            $result = json_decode($response->getBody(), true);
            /**
             * If response comes back 'unauthorized', redirect to the index page.
             */
            if ($result['status'] === 'unauthorized') {
                $this->_redirect('*/dashboard', ['unauthorized']);
            } else {
                /**
                 * Save returned token into the core_config_data table.
                 */
                $api_token = $result['token'];
                $this->_config->saveConfig('springbot/configuration/security_token', $api_token, 'default', 0);
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }

        /**
         * @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        $resultPage = $this->getResultPageFactory()->create();
        $resultPage->setActiveMenu('Springbot_Main::main');
        $resultPage->addBreadcrumb(__('Springbot'), __('Springbot'));
        $resultPage->getConfig()->getTitle()->prepend(__('Springbot'));
        return $resultPage;
    }

    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function getResultPageFactory()
    {
        return $this->resultPageFactory;
    }
}
