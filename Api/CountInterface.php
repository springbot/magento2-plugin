<?php

namespace Springbot\Main\Api;

interface CountInterface
{

    /**
     * @return string
     * @return void
     */
    public function getEntityType();

    /**
     * @param string $entityType
     * @return void
     */
    public function setEntityType($entityType);

    /**
     * @return int
     */
    public function getCount();

    /**
     * @param int $count
     * @return void
     */
    public function setCount($count);
}
