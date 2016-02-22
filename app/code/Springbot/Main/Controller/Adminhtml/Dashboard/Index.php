<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
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

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Springbot_Main::index');
    }
}
