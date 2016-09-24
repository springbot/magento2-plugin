<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\ObjectManager;

/**
 * Class Redirects
 * @package Springbot\Main\Model
 */
class Redirects extends AbstractModel
{

    /**
     * @return array
     */
    public function getRedirects()
    {
        $om = ObjectManager::getInstance();
        $urlRewrite = $om->get('Magento\UrlRewrite\Model\UrlRewrite');
        $collection = $urlRewrite->getCollection();
        $ret = $collection->toArray();
        array_shift($ret);
        return $ret;

    }
}