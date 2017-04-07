<?php

namespace Springbot\Main\Api;

/**
 * Interface RedirectInterface
 *
 * @package Springbot\Main\Api
 */
interface RedirectInterface
{

    /**
     * @param $urlRewriteId
     * @param $requestPath
     * @param $targetPath
     * @param $redirectType
     * @param $storeId
     * @param $description
     * @return void
     */
    public function setValues($urlRewriteId, $requestPath, $targetPath, $redirectType, $storeId, $description);

    /**
     * @return int
     */
    public function getUrlRewriteId();

    /**
     * @return string
     */
    public function getRequestPath();

    /**
     * @return string
     */
    public function getTargetPath();

    /**
     * @return string
     */
    public function getRedirectType();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getDescription();
}
