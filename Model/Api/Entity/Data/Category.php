<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Api\Entity\Data\CategoryInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class Category
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Category implements CategoryInterface
{
    public $storeId;
    public $categoryId;
    public $level;
    public $path;
    public $createdAt;
    public $updatedAt;
    public $name;
    public $urlPath;
    public $description;
    public $requestPath;
    public $targetPath;
    public $categoryAttributes = [];

    private $resourceConnection;
    private $scopeConfig;
    private $storeManager;
    private $productMetadata;

    /**
     * Guest constructor.
     * @param ResourceConnection $resourceConnection
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        ProductMetadataInterface $productMetadata
    ) {

        $this->resourceConnection = $resourceConnection;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->productMetadata = $productMetadata;
    }

    /**
     * @param $storeId
     * @param $categoryId
     * @param $level
     * @param $path
     * @param $createdAt
     * @param $updatedAt
     * @param $requestPath
     * @param $targetPath
     */
    public function setValues($storeId, $categoryId, $level, $path, $createdAt, $updatedAt, $requestPath, $targetPath)
    {
        $this->storeId = $storeId;
        $this->categoryId = $categoryId;
        $this->level = $level;
        $this->path = $path;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->requestPath = $requestPath;
        $this->targetPath = $targetPath;
        $this->loadAttributes();
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrlPath()
    {
        return $this->urlPath;
    }

    public function getUrl()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB)
        . $this->requestPath;
    }


    public function getUrlIdPath()
    {
        $store = $this->storeManager->getStore($this->storeId);
        return $store->getBaseUrl(UrlInterface::URL_TYPE_WEB)
        . $this->targetPath;
    }

    public function getIsActive()
    {
        return true;
    }

    public function getDescription()
    {
        return $this->description;
    }

    private function loadAttributes()
    {
        $version = $this->productMetadata->getVersion();
        $edition = $this->productMetadata->getEdition();

        if ((in_array($edition, ['Enterprise', 'B2B'])) && version_compare($version, '2.1', '>=')) {
            $idColumnName = 'row_id';
        } else {
            $idColumnName = 'entity_id';
        }

        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $query = $conn->query("
            SELECT ea.attribute_code AS `code`, eav.value  AS 'value'
            FROM {$resource->getTableName('catalog_category_entity')} cce
              LEFT JOIN {$resource->getTableName('catalog_category_entity_datetime')} eav ON (cce.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
              LEFT JOIN {$resource->getTableName('url_rewrite')} ur ON (ur.entity_id = cce.entity_id)
            WHERE ur.store_id = {$this->storeId} AND (cce.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('catalog_category_entity')} cce
              LEFT JOIN {$resource->getTableName('catalog_category_entity_decimal')} eav ON (cce.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
              LEFT JOIN {$resource->getTableName('url_rewrite')} ur ON (ur.entity_id = cce.entity_id)
            WHERE ur.store_id = {$this->storeId} AND (cce.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('catalog_category_entity')} cce
              LEFT JOIN {$resource->getTableName('catalog_category_entity_int')} eav ON (cce.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
              LEFT JOIN {$resource->getTableName('url_rewrite')} ur ON (ur.entity_id = cce.entity_id)
            WHERE ur.store_id = {$this->storeId} AND (cce.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('catalog_category_entity')} cce
              LEFT JOIN {$resource->getTableName('catalog_category_entity_text')} eav ON (cce.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
              LEFT JOIN {$resource->getTableName('url_rewrite')} ur ON (ur.entity_id = cce.entity_id)
            WHERE ur.store_id = {$this->storeId} AND (cce.{$idColumnName} = :{$idColumnName})
            UNION
            SELECT ea.attribute_code AS `code`, eav.value AS 'value'
            FROM {$resource->getTableName('catalog_category_entity')} cce
              LEFT JOIN {$resource->getTableName('catalog_category_entity_varchar')} eav ON (cce.{$idColumnName} = eav.{$idColumnName})
              LEFT JOIN {$resource->getTableName('eav_attribute')} ea ON (eav.attribute_id = ea.attribute_id)
              LEFT JOIN {$resource->getTableName('url_rewrite')} ur ON (ur.entity_id = cce.entity_id)
            WHERE ur.store_id = {$this->storeId} AND (cce.{$idColumnName} = :{$idColumnName});
        ", [$idColumnName => $this->categoryId]);

        foreach ($query->fetchAll() as $attributeRow) {
            $value = $attributeRow['value'];
            switch ($attributeRow['code']) {
                case 'name':
                    $this->name = $value;
                    break;
                case 'description':
                    $this->description = $value;
                    break;
                default:
                    if ($value !== null) {
                    }
            }
        }
    }
}
