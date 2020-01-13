<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Springbot\Main\Api\Entity\Data\V2ProductInterface;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Product as MagentoProduct;
use Springbot\Main\Model\Api\Entity\Data\Product\ProductAttribute;

/**
 * Class Order
 *
 *  Reference pages:
 *  Springbot\Main\Model\Api\Entity\AbstractRepository
 *  Springbot\Main\Model\Api\Entity\ProductRepository
 *  Springbot\Main\Api\Entity\Data\ProductRepositoryInterface
 *  Springbot\Main\Api\Entity\Data\ProductInterface
 *
 *
 * @package Springbot\Main\Model\Handler
 */
 
class V2Product extends MagentoProduct implements V2ProductInterface
{
    public $categoryIds = [];
    public $allCategoryIds = [];

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return parent::getEntityId();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return parent::getName();
    }

    /**
     * @return mixed
     */
    public function getUrlKey()
    {
        return parent::getUrlKey();
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return parent::getSku();
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return parent::getTypeId();
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return parent::getStatus();
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return parent::getVisibility();
    }

    /**
     * @return mixed
     */
    public function getMsrp()
    {
        return parent::getMsrp();
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return parent::getPrice();
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return parent::getCost();
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return parent::getWeight();
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return parent::getCreatedAt();
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return parent::getUpdatedAt();
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return parent::getDescription();
    }

    /**
     * @return mixed
     */
    public function getShortDescription()
    {
        return parent::getShortDescription();
    }

    /**
     * @return mixed
     */
    public function getCategoryIds()
    {
        return parent::getCategoryIds();
    }

    /**
     * @return mixed
     */
    public function getRootCategoryIds()
    {
        return parent::getRootCategoryIds();
    }

    /**
     * @return mixed
     */
    public function getAllCategoryIds()
    {
        $om = ObjectManager::getInstance();
        $resource = $om->get('Magento\Framework\App\ResourceConnection');
        $version = $om->get('Magento\Framework\App\ProductMetadataInterface')->getVersion();
        $edition = $om->get('Magento\Framework\App\ProductMetadataInterface')->getEdition();
        if ((in_array($edition, ['Enterprise', 'B2B'])) && version_compare($version, '2.1', '>=')) {
            $idColumnName = 'row_id';
        } else {
            $idColumnName = 'entity_id';
        }

        $conn = $resource->getConnection();
        $query = $conn->query("SELECT * FROM {$resource->getTableName('catalog_category_product')}  ccp
          LEFT JOIN {$resource->getTableName('catalog_category_entity')} cce ON (ccp.category_id = cce.{$idColumnName})
          WHERE product_id = :{$idColumnName}", [$idColumnName => $this->getProductId()]);
        foreach ($query->fetchAll() as $row) {
            $allParents = explode('/', $row['path']);
            $this->categoryIds[] = $row['category_id'];
            $this->allCategoryIds = array_merge($allParents, $this->allCategoryIds);
        }
        return array_unique($this->allCategoryIds);
    }

    /**
     * @return mixed
     */
    public function getSpecialPrice()
    {
        return parent::getSpecialPrice();
    }

    /**
     * @return mixed
     */
    public function getUrlInStore($params = [])
    {
        return parent::getUrlInStore($params);
    }

    /**
     * @return mixed
     */
    public function getImageLabel()
    {
        return parent::getImageLabel();
    }

    /**
     * @return mixed
     */
    public function getCustomAttributeSetId()
    {
        return parent::getAttributeSetId();
    }
    
    /**
     * @return mixed
     */
    public function getProductAttributes()
    {
        $attributes = [];
        foreach (parent::getCustomAttributes() as $customAttribute) {
            $attributes[] = new ProductAttribute($customAttribute->getAttributeCode(), $this->getResource()->getAttribute($customAttribute->getAttributeCode())->getFrontend()->getValue($this));
        }
        return $attributes;
    }

    /**
     * @return string
     */	
    public function getDefaultUrl()
    {
        return $this->getProductUrl();
    }
    
    /**
     * @return string
     */
    public function getUrlIdPath()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getId();
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->getImage();
    }

    /**
     * @return string[]
     */
    public function getParentSkus()
    {
        $om = ObjectManager::getInstance();
        $typeConfigurable = $om->get('Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable');
        $parentIds = $typeConfigurable->getParentIdsByChild($this->getId());
        $skus = [];
        $productLoader = $om->get('Magento\Catalog\Model\ProductFactory');
        foreach ($parentIds as $parentId) {
            $parent = $productLoader->create()->load($parentId);
            $skus[] = $parent->getSku();
        }
        return $skus;
    }

    /**
     * @return string
     */
    private function getIdColumnName()
    {
        $om = ObjectManager::getInstance();
        $version = $om->get('Magento\Framework\App\ProductMetadataInterface')->getVersion();
        $edition = $om->get('Magento\Framework\App\ProductMetadataInterface')->getEdition();
        if ((in_array($edition, ['Enterprise', 'B2B'])) && version_compare($version, '2.1', '>=')) {
            return 'row_id';
        } else {
            return 'entity_id';
        }
    }
}
