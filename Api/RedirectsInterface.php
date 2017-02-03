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
     * @param  int $storeId
     * @return \Springbot\Main\Api\RedirectInterface[]
     */
    public function getRedirects($storeId);

    /**
     * @param string $requestPath
     * @param string $redirectType
     * @param string $idPath
     * @param string $targetPath
     * @param string $storeId
     * @param string $description
     * @return \Springbot\Main\Api\RedirectInterface
     */
    public function createRedirect($requestPath, $redirectType, $idPath, $targetPath, $storeId, $description);
}
