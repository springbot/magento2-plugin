<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\StoreInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Store
 *
 * @package Springbot\Main\Model\Api
 */
class Store implements StoreInterface
{

    public $storeId;
    public $websiteId;
    public $name;
    public $code;
    public $websiteName;
    public $websiteCode;
    public $isActive;

    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }


    /**
     * @param $storeId
     * @param $websiteId
     * @param $name
     * @param $code
     * @param $websiteName
     * @param $websiteCode
     * @param $isActive
     */
    public function setValues(
        $storeId,
        $websiteId,
        $name,
        $code,
        $websiteName,
        $websiteCode,
        $isActive
    ) {
        $this->storeId = $storeId;
        $this->websiteId = $websiteId;
        $this->name = $name;
        $this->code = $code;
        $this->websiteName = $websiteName;
        $this->websiteCode = $websiteCode;
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return mixed
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getWebsiteName()
    {
        return $this->websiteName;
    }

    public function getWebsiteCode()
    {
        return $this->websiteCode;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getSpringbotGuid()
    {
        return $this->scopeConfig->getValue('springbot/configuration/store_guid_' . $this->storeId);
    }

    /**
     * @return mixed
     */
    public function getSpringbotStoreId()
    {
        return $this->scopeConfig->getValue('springbot/configuration/store_id_' . $this->storeId);
    }
}
