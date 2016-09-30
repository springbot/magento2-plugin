<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Api\Entity\Data\CategoryInterface;

/**
 * Class Category
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Category implements CategoryInterface
{

    public $categoryId;
    public $level;
    public $path;
    public $createdAt;
    public $updatedAt;
    public $categoryAttributes = [];

    public $name;
    public $urlPath;
    public $description;

    /**
     * Category constructor.
     * @param $categoryId
     * @param $level
     * @param $path
     * @param $createdAt
     * @param $updatedAt
     */
    public function setValues($categoryId, $level, $path, $createdAt, $updatedAt)
    {
        $this->categoryId = $categoryId;
        $this->level = $level;
        $this->path = $path;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->loadAttributes();
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
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
        // TODO: Implement getUrl() method.
    }

    public function getIsActive()
    {
        // TODO: Implement getIsActive() method.
    }

    public function getDescription()
    {
        return $this->description;
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
            LEFT JOIN {$conn->getTableName('catalog_category_entity_text')} cpet
                ON (ea.attribute_id = cpet.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_category_entity_datetime')} cped
                ON (ea.attribute_id = cped.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_category_entity_decimal')} cpedec
                ON (ea.attribute_id = cpedec.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_category_entity_int')} cpei
                ON (ea.attribute_id = cpei.attribute_id)
            LEFT JOIN {$conn->getTableName('catalog_category_entity_varchar')} cpev
                ON (ea.attribute_id = cpev.attribute_id)
            WHERE cpet.entity_id = :entity_id 
             OR cped.entity_id = :entity_id
             OR cpedec.entity_id = :entity_id
             OR cpei.entity_id = :entity_id 
             OR cpev.entity_id = :entity_id
        ", ['entity_id' => $this->categoryId]);

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
                case 'url_path':
                    $this->urlPath = $value;
                    break;
                default:
                    if ($value !== null) {

                    }
            }
        }
    }


}
