<?php

namespace Springbot\Main\Model\Api;

use Springbot\Main\Api\RedirectInterface;

/**
 * Class Redirects
 *
 * @package Springbot\Main\Model
 */
class Redirect implements RedirectInterface
{

    public $urlRewriteId;
    public $requestPath;
    public $targetPath;
    public $redirectType;
    public $storeId;
    public $description;

    public function setValues($urlRewriteId, $requestPath, $targetPath, $redirectType, $storeId, $description)
    {
        $this->urlRewriteId = $urlRewriteId;
        $this->requestPath = $requestPath;
        $this->targetPath = $targetPath;
        $this->redirectType = $redirectType;
        $this->storeId = $storeId;
        $this->description = $description;
    }

    public function getUrlRewriteId()
    {
        return $this->urlRewriteId;
    }

    public function getRequestPath()
    {
        return $this->requestPath;
    }

    public function getTargetPath()
    {
        return $this->targetPath;
    }

    public function getRedirectType()
    {
        return $this->redirectType;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
