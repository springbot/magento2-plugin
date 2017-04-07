<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Helper\Context as HelperContext;
use Springbot\Main\Model\Register;
use Springbot\Main\Model\Api;

/**
 * Class Index
 *
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Index extends Action
{
    protected $resultPageFactory;
    protected $helperContext;
    private $register;
    private $api;

    /**
     * Index constructor.
     *
     * @param Context       $context
     * @param HelperContext $helperContext
     * @param PageFactory   $resultPageFactory
     * @param Register      $register
     * @param Api           $api
     */
    public function __construct(
        Context $context,
        HelperContext $helperContext,
        PageFactory $resultPageFactory,
        Register $register,
        Api $api
    ) {
        $this->helperContext = $helperContext;
        $this->resultPageFactory = $resultPageFactory;
        $this->register = $register;
        $this->api = $api;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        // Check to see if security token is set. If so, show the connected screen
        if ($this->register->allStoresRegistered()) {
            return $this->_redirect('springbot/dashboard/connected');
        }

        // Checks if the submission was invalid. If so, displays an error to the user.
        if ($this->getRequest()->getParam(0) === 'unauthorized') {
            $this->messageManager->addError(__('Incorrect username or password. Please try again.'));
        }

        /* @var \Magento\Backend\Model\View\Result\Page $resultPage */
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

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Springbot_Main::index');
    }
}
