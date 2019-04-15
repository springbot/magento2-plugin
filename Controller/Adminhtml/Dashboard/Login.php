<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Springbot\Main\Model\Register;
use Psr\Log\LoggerInterface;

/**
 * Class Login
 *
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Login extends Action
{
    private $register;
    private $logger;

    /**
     * Login constructor.
     *
     * @param Context         $context
     * @param LoggerInterface $logger
     * @param Register        $register
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        Register $register
    ) {
        $this->logger = $logger;
        $this->register = $register;
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
        $request = $this->getRequest();
        $springbotEmail = $request->getParam('springbot-email');
        $springbotPassword = $request->getParam('springbot-password');
        $registered = $this->register->registerAllStores($springbotEmail, $springbotPassword);

        if ($registered === true) {
            return $this->_redirect('springbot/dashboard/connected');
        } else {
            // If response comes back 'unauthorized', redirect to the index page.
            $this->_redirect('*/dashboard', ['unauthorized']);
        }
    }
}
