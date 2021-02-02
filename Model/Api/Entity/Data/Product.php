<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\Product as MagentoProduct;
use Magento\Catalog\Model\Product\Image as MagentoProductImage;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
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

    protected $productRepository;
    protected $connectionResource;
    protected $storeManager;
    protected $urlInterface;
    protected $scopeConfigInterface;

    private $imagePath;
    private $productMetadata;

    /**
     * Product constructor.
     * @param \Magento\Framework\App\ResourceConnection $connectionResource
     * @param \Springbot\Main\Api\Entity\ProductRepositoryInterface $productRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Model\UrlInterface $urlInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param ProductMetadataInterface $productMetadata
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(
        ResourceConnection $connectionResource,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        ScopeConfigInterface $scopeConfig,
        ProductMetadataInterface $productMetadata,
        LoggerInterface $loggerInterface
    ) {

        $this->productRepository = $productRepository;
        $this->connectionResource = $connectionResource;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->scopeConfigInterface = $scopeConfig;
        $this->productMetadata = $productMetadata;
        $this->logger = $loggerInterface;
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
    public function setValues($storeId, $productId, $sku, $type, $createdAt, $updatedAt, $customAttributeSetId)
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

    /**
     * @return string
     */
    public function getUrlIdPath()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'catalog/product/view/id/' . $this->getProductId();
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        if (! $this->imagePath) {
            return null;
        }
        if (mb_substr($this->imagePath, 0, 1) != '/') {
          $bufferSlash = '/';
        } else {
          $bufferSlash = '';
        }
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $bufferSlash . $this->imagePath;
    }

    /**
     * @return string[]
     */
    public function getParentSkus()
    {
        $idColumnName = $this->getIdColumnName();
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $query = $conn->query("SELECT cpe.sku,cpe.type_id FROM {$resource->getTableName('catalog_product_relation')} cper
            LEFT JOIN {$resource->getTableName('catalog_product_entity')} cpe
              ON (cper.parent_id = cpe.{$idColumnName})
                WHERE cper.child_id = :{$idColumnName}
        ", [$idColumnName => $this->productId]);
        $skus = [];
        foreach ($query->fetchAll() as $parentRow) {
            if ($parentRow['type_id'] != 'bundle') {
                $skus[] = $parentRow['sku'];
            }
        }
        return $skus;
    }

    private function loadAttributes()
    {
        $om = ObjectManager::getInstance();
        $idColumnName = $this->getIdColumnName();
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $query = $conn->query("
            SELECT ea.attribute_code AS `code`, eav.value  AS 'value', ea.source_model AS 'source_model', ea.backend_model AS 'backend_model', ea.attribute_id AS 'attribute_id'
            FROM {$resource->getTableName('catalog_product_entity')} cpe
              LEFT JOIN {$resource->getTableName('catalog_product_entity_datetime')} eav ON (cpe.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (cpe.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value', ea.source_model AS 'source_model', ea.backend_model AS 'backend_model', ea.attribute_id AS 'attribute_id'
            FROM {$resource->getTableName('catalog_product_entity')} cpe
              LEFT JOIN {$resource->getTableName('catalog_product_entity_decimal')} eav ON (cpe.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (cpe.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value', ea.source_model AS 'source_model', ea.backend_model AS 'backend_model', ea.attribute_id AS 'attribute_id'
            FROM {$resource->getTableName('catalog_product_entity')} cpe
              LEFT JOIN {$resource->getTableName('catalog_product_entity_int')} eav ON (cpe.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (cpe.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value', ea.source_model AS 'source_model', ea.backend_model AS 'backend_model', ea.attribute_id AS 'attribute_id'
            FROM {$resource->getTableName('catalog_product_entity')} cpe
              LEFT JOIN {$resource->getTableName('catalog_product_entity_text')} eav ON (cpe.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (cpe.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value', ea.source_model AS 'source_model', ea.backend_model AS 'backend_model', ea.attribute_id AS 'attribute_id'
            FROM {$resource->getTableName('catalog_product_entity')} cpe
              LEFT JOIN {$resource->getTableName('catalog_product_entity_varchar')} eav ON (cpe.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
            WHERE (cpe.{$idColumnName} = :{$idColumnName});
        ", [$idColumnName => $this->productId]);

        foreach ($query->fetchAll() as $attributeRow) {
            $value = $attributeRow['value'];
            switch ($attributeRow['code']) {
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
                        try {
                            if ($attributeRow['source_model'] && class_exists($attributeRow['source_model'])) {
                                $sourceModel = $om->get($attributeRow['source_model']);
                                $value = $sourceModel->getOptionText($attributeRow['value']);
                                $this->productAttributes[] = new ProductAttribute($attributeRow['code'], $value);
                            } else if ($attributeRow['backend_model']) {
                                $eavModel = $om->create('Magento\Catalog\Model\ResourceModel\Eav\Attribute');
                                $attr = $eavModel->load($attributeRow['attribute_id']);
                                $selectedValues = $attr->getSource()->getOptionText($value);
                                if (is_array($selectedValues)) {
                                    foreach ($selectedValues as $selectedValue) {
                                        $this->productAttributes[] = new ProductAttribute($attributeRow['code'], $selectedValue);
                                    }
                                } else if (is_string($selectedValues)) {
                                    $this->productAttributes[] = new ProductAttribute($attributeRow['code'], $selectedValues);
                                }
                            } else {
                                $this->productAttributes[] = new ProductAttribute($attributeRow['code'], $value);
                            }
                        } catch (\Throwable $t) {
							//Removed logging to prevent log backup.
                        }
                    }
            }
        }
    }

    private function loadCategories()
    {
        $idColumnName = $this->getIdColumnName();
        $resource = $this->connectionResource;
        $conn = $resource->getConnection();
        $query = $conn->query("SELECT * FROM {$resource->getTableName('catalog_category_product')}  ccp
          LEFT JOIN {$resource->getTableName('catalog_category_entity')} cce ON (ccp.category_id = cce.{$idColumnName})
          WHERE product_id = :{$idColumnName}", [$idColumnName => $this->productId]);
        foreach ($query->fetchAll() as $row) {
            $allParents = explode('/', $row['path']);
            $this->categoryIds[] = $row['category_id'];
            $this->allCategoryIds = array_merge($allParents, $this->allCategoryIds);
        }
        $this->allCategoryIds = array_unique($this->allCategoryIds);
    }

    /**
     * @return string
     */
    private function getIdColumnName()
    {
        $version = $this->productMetadata->getVersion();
        $edition = $this->productMetadata->getEdition();

        if ((in_array($edition, ['Enterprise', 'B2B'])) && version_compare($version, '2.1', '>=')) {
            return 'row_id';
        } else {
            return 'entity_id';
        }
    }
}
