<?php
namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface V2ProductInterface
 * @package Springbot\Main\Api
 */
interface V2ProductInterface
{
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
     * @return array
     */
    public function getCategoryIds();
    /**
     * @return array
     */
    public function getRootCategoryIds();
    /**
     * @return array
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
     * @return array
     */
    public function getParentSkus();
    /**
     * @return array
     */
    public function getCustomAttributeSetId();
    /**
     * @return \Springbot\Main\Api\Entity\Data\Product\V2ProductAttributeInterface[]
     */
    public function getProductAttributes();
}