<?php

namespace Springbot\Main\Api;

/**
 * Interface RedirectsInterface
 * @package Springbot\Main\Api
 */
interface RedirectsInterface
{

    /**
     * Return a list of all redirects
     *
     * @param int $storeId
     * @return \Springbot\Main\Api\RedirectInterface[]
     */
    public function getRedirects($storeId);

}