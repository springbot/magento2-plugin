<?php

namespace Springbot\Main\Model\Api;

use Magento\UrlRewrite\Model\UrlRewrite;

/**
 * Class Redirects
 * @package Springbot\Main\Model
 */
class Redirects
{

    private $urlRewrite;

    /**
     * Redirects constructor.
     * @param UrlRewrite $urlRewrite
     */
    public function __construct(UrlRewrite $urlRewrite)
    {
        $this->urlRewrite = $urlRewrite;
    }

    /**
     * @return array
     */
    public function getRedirects()
    {
        $collection = $this->urlRewrite->getCollection();
        $ret = $collection->toArray();
        array_shift($ret);
        return $ret;
    }
}