<?php

namespace Springbot\Main\Helper;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;

/**
 * Class QueueProductChanges
 * @package Springbot\Main\Helper
 */
class QueueProductChanges extends AbstractHelper
{
    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * QueueProductChanges constructor.
     *
     * @param Context $context
     * @param LoggerInterface $loggerInterface
     * @param ProductFactory $productFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        ProductFactory $productFactory
    ) {
        $this->_logger = $loggerInterface;
        $this->_productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * @param $storeId
     * @param $productId
     */
    public function updateProduct($storeId, $productId)
    {
        $product = $this->_productFactory->create();
        $product->setStoreId($storeId)->load($productId);
        $jsonData = json_encode($product->getData());
        $this->_logger->debug($jsonData);
    }

    /**
     * @param $storeId
     * @param $productId
     */
    public function deleteProduct($storeId, $productId)
    {
        $product = $this->_productFactory->create();
        $product->setStoreId($storeId)->load($productId);
        $jsonData = json_encode($product->getData());
        $this->_logger->debug($jsonData);
    }
}
