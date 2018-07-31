<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Catalog\Model\Product as MagentoProduct;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Backend\Model\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Springbot\Main\Api\Entity\Data\ProductInterface;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\Product\ProductAttribute;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class Product
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class ProductV2 extends MagentoProduct implements ProductInterface
{

    public $storeId;
    public $productId;
    public $sku;
    public $type;
    public $createdAt;
    public $updatedAt;
    public $categoryIds = [];
    public $allCategoryIds = [];
    public $customAttributeSetId;
	
    /**
     * @param $storeId
     * @param $productId
     * @param $sku
     * @param $type
     * @param $createdAt
     * @param $updatedAt
     * @param $customAttributeSetId
     */
    public function setValues($storeId, $productId, $sku, $type,  $createdAt, $updatedAt,  $customAttributeSetId)
    {
        $this->storeId = $storeId;
        $this->productId = $productId;
        $this->sku = $sku;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->customAttributeSetId = $customAttributeSetId;
        $this->loadCategories();
    }
	
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
        return $this->categoryIds;
    }

    /**
     * @return mixed
     */
    public function getAllCategoryIds()
    {
        return $this->allCategoryIds;
    }

    /**
     * @return mixed
     */
    public function getSpecialPrice()
    {
       return parent::getSpecialPrice();
    }
	
    public function getUrlInStore($params = array())
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
            $attributes[] = new ProductAttribute($customAttribute->getAttributeCode(), $customAttribute->getValue());
        }
        return $attributes;
    }

    /**
     * @return mixed
     */
    public function getDefaultUrl()
    {
        return $this->getProductUrl();
    }

    /**
     * @return mixed
     */
    public function getUrlIdPath()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getId();
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        $om = ObjectManager::getInstance();
        $store = $om->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->getImage();
    }

    /**
     * @return mixed
     */
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
	
    /**
     * @return string
     */
    private function getIdColumnName()
    {
        $om = ObjectManager::getInstance();
		$productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
        $version = $productMetadata->getVersion();
        $edition = $productMetadata->getEdition();

        if (($edition === 'Enterprise') &&  version_compare($version, '2.1', '>=')) {
            return 'row_id';
        }
        else {
            return 'entity_id';
        }
    }
	    
	private function loadCategories()
    {
        $idColumnName = $this->getIdColumnName();
        $conn = ResourceConnection::getConnection();
        $query = $conn->query("SELECT * FROM {ResourceConnection::getTableName('catalog_category_product')}  ccp
          LEFT JOIN {ResourceConnection::getTableName('catalog_category_entity')} cce ON (ccp.category_id = cce.{$idColumnName})
          WHERE product_id = :{$idColumnName}", [$idColumnName => $this->productId]);
        foreach ($query->fetchAll() as $row) {
            $allParents = explode('/', $row['path']);
            $this->categoryIds[] = $row['category_id'];
            $this->allCategoryIds = array_merge($allParents, $this->allCategoryIds);
        }
        $this->allCategoryIds = array_unique($this->allCategoryIds);
    }
}