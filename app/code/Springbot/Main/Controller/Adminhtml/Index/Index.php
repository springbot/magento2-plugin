<?php

namespace Springbot\Main\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultsPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultsPageFactory
    ) {
        parent::__construct($context);
        $this->resultsPageFactory = $resultsPageFactory;
    }

    public function execute() {
        $resultsPage = $this->resultsPageFactory->create();

        $resultsPage->setHeader('title', 'Springbot Dashboard');
        return $resultsPage;
    }
}
