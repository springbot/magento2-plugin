<?php

namespace Springbot\Main\Model;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Helper\Data;
use Springbot\Main\Model\Api;

/**
 * Class Handler
 * @package Springbot\Main\Model
 */
abstract class Handler
{

    const DATA_SOURCE_BH = 'BH';
    const DATA_SOURCE_OB = 'OB';

    abstract public function handle($storeId, $productId);
    abstract public function handleDelete($storeId, $productId);

}
