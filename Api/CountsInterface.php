<?php

namespace Springbot\Main\Api;

/**
 * @api
 */
interface CountsInterface
{
    /**
     * Returns an array of all the entity counts we care about.
     *
     * @param int $storeId
     * @return array
     */
    public function getCounts($storeId);
}
