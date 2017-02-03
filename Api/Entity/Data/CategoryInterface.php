<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * Interface CategoryInterface
 *
 * @package Springbot\Main\Api\Entity\Data
 */
interface CategoryInterface
{

    /**
     * @return int
     */
    public function getCategoryId();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getLevel();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getUrlPath();

    /**
     * @return string
     */
    public function getUrl();


    /**
     * @return string
     */
    public function getUrlIdPath();

    /**
     * @return boolean
     */
    public function getIsActive();

    /**
     * @return string
     */
    public function getDescription();
}
