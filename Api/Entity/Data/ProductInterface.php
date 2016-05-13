<?php

namespace Springbot\Main\Api\Data;

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


}
