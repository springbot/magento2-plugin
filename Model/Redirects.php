<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;

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
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $urlRewrite = $om->get('Magento\UrlRewrite\Model\UrlRewrite');
        $collection = $urlRewrite->getCollection();
        $ret = $collection->toArray();
        array_shift($ret);
        return $ret;

    }
}