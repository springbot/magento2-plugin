<?php

namespace Springbot\Main\Helper;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;

/**
 * Class QueueCategoryChanges
 * @package Springbot\Main\Helper
 */
class QueueCategoryChanges extends AbstractHelper
{
    /**
     * @var CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * QueueCategoryChanges constructor.
     *
     * @param Context $context
     * @param LoggerInterface $loggerInterface
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        CategoryFactory $categoryFactory
    ) {
        $this->_logger = $loggerInterface;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
     * @param $storeId
     * @param $categoryId
     */
    public function updateCategory($storeId, $categoryId)
    {
        $category = $this->_categoryFactory->create();
        $categoryId->setStoreId($storeId)->load($categoryId);
        $jsonData = json_encode($category->getData());
        $this->_logger->debug($jsonData);
    }

    /**
     * @param $storeId
     * @param $categoryId
     */
    public function deleteCategory($storeId, $categoryId)
    {
        $category = $this->_categoryFactory->create();
        $categoryId->setStoreId($storeId)->load($categoryId);
        $jsonData = json_encode($category->getData());
        $this->_logger->debug($jsonData);
    }
}
