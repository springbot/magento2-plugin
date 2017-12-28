<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface ProductInterface
 *
 * @package Springbot\Main\Api
 */
interface ProductInterface
{

    /**
     * @param $storeId
     * @param $productId
     * @param $sku
     * @param $type
     * @param $createdAt
     * @param $updatedAt
     * @param $customAttributeSetId
     * @return void
     */
    public function setValues($storeId, $productId, $sku, $type, $createdAt, $updatedAt, $customAttributeSetId);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getVisibility();

    /**
     * @return string
     */
    public function getMsrp();

    /**
     * @return string
     */
    public function getPrice();

    /**
     * @return string
     */
    public function getCost();

    /**
     * @return string
     */
    public function getWeight();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getShortDescription();

    /**
     * @return int[]
     */
    public function getCategoryIds();

    /**
     * @return int[]
     */
    public function getAllCategoryIds();

    /**
     * @return string
     */
    public function getSpecialPrice();

    /**
     * @return string
     */
    public function getDefaultUrl();

    /**
     * @return string
     */
    public function getUrlInStore();

    /**
     * @return string
     */
    public function getUrlIdPath();

    /**
     * @return string
     */
    public function getImageUrl();

    /**
     * @return string
     */
    public function getImageLabel();

    /**
     * @return string[]
     */
    public function getParentSkus();

    /**
     * @return int
     */
    public function getCustomAttributeSetId();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Product\ProductAttributeInterface[]
     */
    public function getProductAttributes();
}
