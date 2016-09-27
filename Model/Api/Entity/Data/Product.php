<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\ProductInterface;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Product as MagentoProduct;
use Springbot\Main\Model\Api\Entity\Data\Product\ProductAttribute;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends MagentoProduct implements ProductInterface
{

    public function getProductId()
    {
        return parent::getEntityId();
    }

    public function getName()
    {
        return parent::getName();
    }

    public function getUrlKey()
    {
        return parent::getUrlKey();
    }

    public function getSku()
    {
        return parent::getSku();
    }

    public function getType()
    {
        return parent::getTypeId();
    }

    public function getStatus()
    {
        return parent::getStatus();
    }

    public function getVisibility()
    {
        return parent::getVisibility();
    }

    public function getMsrp()
    {
        return parent::getMsrp();
    }

    public function getPrice()
    {
        return parent::getPrice();
    }

    public function getCost()
    {
        return parent::getCost();
    }

    public function getWeight()
    {
        return parent::getWeight();
    }

    public function getCreatedAt()
    {
        return parent::getCreatedAt();
    }

    public function getUpdatedAt()
    {
        return parent::getUpdatedAt();
    }

    public function getDescription()
    {
        return parent::getDescription();
    }

    public function getShortDescription()
    {
        return parent::getShortDescription();
    }

    public function getCategoryIds()
    {
        return parent::getCategoryIds();
    }

    public function getRootCategoryIds()
    {
        // TODO: Implement getRootCategoryIds() method.
    }

    public function getAllCategoryIds()
    {
        // TODO: Implement getAllCategoryIds() method.
    }

    public function getSpecialPrice()
    {
       return parent::getSpecialPrice();
    }

    public function getUrlInStore($params = array())
    {
        return parent::getUrlInStore($params);
    }

    public function getImageLabel()
    {
        return parent::getImageLabel();
    }

    public function getCustomAttributeSetId()
    {
        return parent::getAttributeSetId();
    }

    public function getProductAttributes()
    {
        $attributes = [];
        foreach (parent::getCustomAttributes() as $customAttribute) {
            $attributes[] = new ProductAttribute($customAttribute->getAttributeCode(), $customAttribute->getValue());
        }
        return $attributes;
    }

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
