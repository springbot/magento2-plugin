<?php

namespace Springbot\Main\Helper;

use Magento\Catalog\Model\Attribute;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;

/**
 * Class QueueAttributeChanges
 * @package Springbot\Main\Helper
 */
class QueueAttributeChanges extends AbstractHelper
{

    /**
     * @var Attribute
     */
    protected $_attribute;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * QueueAttributeChanges constructor.
     *
     * @param Context $context
     * @param LoggerInterface $loggerInterface
     * @param Attribute $attribute
     */
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        Attribute $attribute
    ) {
        $this->_logger = $loggerInterface;
        $this->_attribute = $attribute;
        parent::__construct($context);
    }

    /**
     * @param $storeId
     * @param $attributeId
     */
    public function addAttribute($storeId, $attributeId)
    {
        $category = $this->_attribute->create();
        $attributeId->setStoreId($storeId)->load($attributeId);
        $jsonData = json_encode($category->getData());
        $this->_logger->debug($jsonData);
    }
}
