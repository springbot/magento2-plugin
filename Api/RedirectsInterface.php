<?php

namespace Springbot\Main\Api;

/**
 * Interface RedirectsInterface
 *
 * @package Springbot\Main\Api
 */
interface RedirectsInterface
{

    /**
     * Return a list of all redirects
     *
     * @return array
     */
    public function getRedirects();

}