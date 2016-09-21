<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Api\Entity\Data\ProductInterface;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends \Magento\Catalog\Model\Product implements ProductInterface
{

    public function getDefaultUrl()
    {
        return $this->getProductUrl();
    }

    public function getUrlIdPath()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getId();
    }

    public function getImageUrl()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->getImage();
    }

    public function getCost()
    {
        return 0;
    }

    public function getParentSkus()
    {
        $om = ObjectManager::getInstance();
        $typeConfigurable = $om->get('Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable');
        $parentIds = $typeConfigurable->getParentIdsByChild($this->getId());
        $skus = array();
        $productLoader = $om->get('Magento\Catalog\Model\ProductFactory');
        foreach ($parentIds as $parentId) {
            $parent = $productLoader->create()->load($parentId);
            $skus[] = $parent->getSku();
        }
        return $skus;
    }


}
