<?php

namespace Springbot\Main\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Springbot\Main\Model\Api;

/**
 * Class Index
 *
 * @package Springbot\Main\Controller\Adminhtml\Dashboard
 */
class Connected extends Action
{
    protected $resultPageFactory;
    protected $assetRepository;
    protected $api;

    /**
     * Index constructor.
     *
     * @param Context         $context
     * @param PageFactory     $resultPageFactory
     * @param AssetRepository $assetRepository
     * @param Api             $api
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        AssetRepository $assetRepository,
        Api $api
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->assetRepository = $assetRepository;
        $this->api = $api;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /* @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $asset = $this->assetRepository->createAsset('Springbot_Main::img/plugin_dashboard_syncing.jpg');
        $block = $resultPage->getLayout()->getBlock('springbot.dashboard.connected');
        $block->setGraphic($asset->getUrl());
        $block->setAppUrl($this->api->getAppUrl());
        $resultPage->setActiveMenu('Springbot_Main::main');
        $resultPage->addBreadcrumb(__('Springbot'), __('Springbot'));
        $resultPage->getConfig()->getTitle()->prepend(__('Springbot'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Springbot_Main::index');
    }
}
