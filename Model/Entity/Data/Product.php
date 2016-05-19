<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Api\Entity\Data\ProductInterface;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends \Magento\Catalog\Model\Product implements ProductInterface
{

    public function getUrlIdPath()
    {
        return $this->_getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getId();
    }

    public function getImageUrl()
    {
        return $this->_getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->getImage();
    }

    public function getImageLabel()
    {
        return '';
    }

    /**
     * @param $type
     * @return string
     */
    private function _getBaseUrl($type)
    {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $currentStore = $storeManager->getStore();
        return $currentStore->getBaseUrl($type);
    }
}
