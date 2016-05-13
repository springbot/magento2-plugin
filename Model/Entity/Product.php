<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\dATA\ProductInterface;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Product extends \Magento\Catalog\Model\Product implements ProductInterface
{
    public function getUrlIdPath()
    {
        return 'xxx';
        // TODO: Implement getUrlIdPath() method.
    }


}
