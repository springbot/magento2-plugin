<?php

namespace Springbot\Main\Model\Api\Entity\Data;

use Magento\Catalog\Model\Category as MagentoCategory;
use Springbot\Main\Api\Entity\Data\CategoryInterface;

/**
 * Class Category
 * @package Springbot\Main\Model\Api\Entity\Data
 */
class Category extends MagentoCategory implements CategoryInterface
{
    public function getCategoryId()
    {
        return parent::getEntityId();
    }

    public function getPath()
    {
        return parent::getPath();
    }

    public function getLevel()
    {
        return parent::getLevel();
    }

    public function getName()
    {
        return parent::getName();
    }

    public function getUrl()
    {
        return parent::getUrl();
    }

    public function getUrlPath()
    {
        return parent::getUrlKey();
    }

    public function getIsActive()
    {
        return parent::getIsActive();
    }


    public function getDescription()
    {
        return parent::getDescription();
    }


}
