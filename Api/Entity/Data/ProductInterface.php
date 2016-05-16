<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface ProductInterface
 * @package Springbot\Main\Api
 */
interface ProductInterface extends \Magento\Catalog\Api\Data\ProductInterface
{

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
}
