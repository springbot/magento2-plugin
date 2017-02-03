<?php

namespace Springbot\Main\Api;

/**
 * Interface StoresInterface
 *
 * @package Springbot\Main\Api
 */
interface StoreInterface
{

    /**
     * @param $storeId
     * @param $websiteId
     * @param $name
     * @param $code
     * @param $websiteName
     * @param $websiteCode
     * @param $isActive
     * @return void
     */
    public function setValues(
        $storeId,
        $websiteId,
        $name,
        $code,
        $websiteName,
        $websiteCode,
        $isActive
    );

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return int
     */
    public function getWebsiteId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @return string
     */
    public function getSpringbotGuid();

    /**
     * @return string
     */
    public function getSpringbotStoreId();
}
