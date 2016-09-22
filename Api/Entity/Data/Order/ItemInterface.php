<?php

namespace Springbot\Main\Api\Entity\Data\Order;

/**
 * Interface ItemInterface
 * @package Springbot\Main\Api\Entity\Data\Order
 */
interface ItemInterface
{

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return string
     */
    public function getSkuFulfillment();

    /**
     * @return string
     */
    public function getQtyOrdered();

    /**
     * @return string
     */
    public function getLandingUrl();

    /**
     * @return string
     */
    public function getImageUrl();

    /**
     * @return string
     */
    public function getWgt();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDesc();

    /**
     * @return string
     */
    public function getSellPrice();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return string
     */
    public function getProductType();

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
     * @return int
     */
    public function getAttributeSetId();

    /**
     * @return \Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface[]
     */
    public function getProductAttributes();


}
