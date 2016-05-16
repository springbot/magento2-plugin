<?php

namespace Springbot\Main\Model\Entity\Data;

use Springbot\Main\Api\Entity\Data\ProductInterface;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends \Magento\Catalog\Model\Product implements ProductInterface
{

    public function getUrlIdPath()
    {
        return '';
    }

    public function getImageUrl()
    {
        return $this->getImage();
    }

    public function getImageLabel()
    {
        return '';
    }

}
