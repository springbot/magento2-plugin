<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Catalog\Model\Product as MagentoProduct;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Backend\Model\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Springbot\Main\Api\Entity\Data\ProductInterface;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Springbot\Main\Model\Api\Entity\Data\Product\ProductAttribute;

/**
 * Class Product
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Product implements ProductInterface
{
    public $storeId;
    public $productId;
    public $name;
    public $urlKey;
    public $sku;
    public $type;
    public $status;
    public $visibility;
    public $msrp;
    public $price;
    public $cost;
    public $weight;
    public $createdAt;
    public $updatedAt;
    public $description;
    public $shortDescription;
    public $categoryIds = [];
    public $allCategoryIds = [];
    public $specialPrice;
    public $defaultUrl;
    public $urlInStore;
    public $urlIdPath;
    public $imageUrl;
    public $imageLabel;
    public $parentSkus;
    public $customAttributeSetId;
    public $productAttributes = [];

    protected $objectManager;
    protected $productRepository;
    protected $connectionResource;
    protected $storeManager;
    protected $urlInterface;
    protected $scopeConfigInterface;

    private $imagePath;

    /**
     * Product constructor.
     * @param \Magento\Framework\App\ResourceConnection $connectionResource
     * @param \Magento\Framework\App\ObjectManager $objectManager
     * @param \Springbot\Main\Api\Entity\ProductRepositoryInterface $productRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Model\UrlInterface $urlInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ResourceConnection $connectionResource,
        ObjectManager $objectManager,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->objectManager = $objectManager;
        $this->productRepository = $productRepository;
        $this->connectionResource = $connectionResource;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->scopeConfigInterface = $scopeConfig;
    }

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
        $this->loadAttributes();
        $this->loadCategories();
    }


    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return mixed
     */
    public function getMsrp()
    {
        return $this->msrp;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
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
        return $this->specialPrice;
    }

    /**
     * @return mixed
     */
    public function getUrlInStore()
    {
        return $this->urlInStore;
    }

    /**
     * @return mixed
     */
    public function getImageLabel()
    {
        return $this->imageLabel;
    }

    /**
     * @return mixed
     */
    public function getCustomAttributeSetId()
    {
        return $this->customAttributeSetId;
    }

    /**
     * @return mixed
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    /**
     * @return string
     */
    public function getDefaultUrl()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB)
            . $this->urlKey
            . $this->scopeConfigInterface->getValue('catalog/seo/product_url_suffix');
    }

    public function getUrlIdPath()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getProductId();
    }

    public function getImageUrl()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->imagePath;
    }


    public function getParentSkus()
    {
        $conn = $this->connectionResource->getConnection();
        $query = $conn->query("SELECT cpe.sku FROM {$conn->getTableName('catalog_product_relation')} cper
            LEFT JOIN {$conn->getTableName('catalog_product_entity')} cpe
              ON (cper.parent_id = cpe.entity_id)
                WHERE cper.child_id = :entity_id
        ", ['entity_id' => $this->productId]);
        $skus = [];
        foreach ($query->fetchAll() as $parentRow) {
            $skus[] = $parentRow['sku'];
        }
        return $skus;
    }

    private function loadAttributes()
    {
        $conn = $this->connectionResource->getConnection();
        $query = $conn->query("SELECT 
              ea.attribute_code,
              cpet.value as `text`,
              cped.value as `datetime`,
              cpedec.value as `decimal`,
              cpei.value as `int`,
              cpev.value as `varchar`
            FROM {$conn->getTableName('eav_attribute')} ea
            LEFT JOIN {$conn->getTableName('catalog_product_entity_text')} cpet
                ON (ea.attribute_id = cpet.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_product_entity_datetime')} cped
                ON (ea.attribute_id = cped.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_product_entity_decimal')} cpedec
                ON (ea.attribute_id = cpedec.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_product_entity_int')} cpei
                ON (ea.attribute_id = cpei.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_product_entity_varchar')} cpev
                ON (ea.attribute_id = cpev.attribute_id)
            WHERE cpet.entity_id = :entity_id 
             OR cped.entity_id = :entity_id
             OR cpedec.entity_id = :entity_id
             OR cpei.entity_id = :entity_id 
             OR cpev.entity_id = :entity_id
        ", ['entity_id' => $this->productId]);

        foreach($query->fetchAll() as $attributeRow) {
            $value = null;
            if (isset($attributeRow['text'])) {
                $value = $attributeRow['text'];
            }
            else if (isset($attributeRow['datetime'])) {
                $value = $attributeRow['datetime'];
            }
            else if (isset($attributeRow['decimal'])) {
                $value = $attributeRow['decimal'];
            }
            else if (isset($attributeRow['int'])) {
                $value = $attributeRow['int'];
            }
            else if (isset($attributeRow['varchar'])) {
                $value = $attributeRow['varchar'];
            }

            switch($attributeRow['attribute_code']) {
                case 'name':
                    $this->name = $value;
                    break;
                case 'cost':
                    $this->cost = $value;
                    break;
                case 'msrp':
                    $this->msrp = $value;
                    break;
                case 'url_key':
                    $this->urlKey = $value;
                    break;
                case 'weight':
                    $this->weight = $value;
                    break;
                case 'description':
                    $this->description = $value;
                    break;
                case 'short_description':
                    $this->shortDescription = $value;
                    break;
                case 'price':
                    $this->price = $value;
                    break;
                case 'image_label':
                    $this->imageLabel = $value;
                    break;
                case 'visibility':
                    $this->visibility = $value;
                    break;
                case 'status':
                    $this->status = $value;
                    break;
                case 'special_price':
                    $this->specialPrice = $value;
                    break;
                case 'image':
                    $this->imagePath = $value;
                    break;
                default:
                    if ($value !== null) {
                        $this->productAttributes[] = new ProductAttribute($attributeRow['attribute_code'], $value); ;
                    }
            }
        }
    }

    private function loadCategories()
    {
        $conn = $this->connectionResource->getConnection();
        $query = $conn->query("SELECT * FROM {$conn->getTableName('catalog_category_product')}  ccp
          LEFT JOIN catalog_category_entity cce ON (ccp.category_id = cce.entity_id)
          WHERE product_id = :entity_id", ['entity_id' => $this->productId]);
        foreach ($query->fetchAll() as $row) {
            $allParents = explode('/', $row['path']);
            $this->categoryIds[] = $row['category_id'];
            $this->allCategoryIds = array_merge($allParents, $this->allCategoryIds);
        }
        $this->allCategoryIds = array_unique($this->allCategoryIds);
    }


}
