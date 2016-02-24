<?php

namespace Springbot\Main\Helper;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Psr\Log\LoggerInterface;

class HarvestProducts extends AbstractHelper
{
    protected $_productFactory;

    protected $_logger;

    public function __construct(
        LoggerInterface $loggerInterface,
        ProductFactory $productFactory
    ) {
        $this->_logger = $loggerInterface;
        $this->_productFactory = $productFactory;
    }

    public function updateProduct($storeId, $productId)
    {
        $product = $this->_productFactory->create();
        $product->load($productId);
        $this->_logger->debug($product->getData('name'));
    }
}
