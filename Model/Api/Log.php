<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\LogInterface;

/**
 * Class Log
 * @package Springbot\Main\Api
 */
class Log extends AbstractModel implements LogInterface
{
    /**
     * @param TypeListInterface $logTypeList
     * @param StateInterface $logState
     * @param Pool $pool
     */
    public function __construct()
    {
        #
    }

    /**
     * Retrieve logs
     *
     * @param string $filename
     * @return string|null
     */
    public function retrieve($filename = "system.log")
    {
        $unixFriendly = str_replace('\\', '/', __DIR__);
        $fullArray = explode('/', $unixFriendly);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        $docroot = implode('/', $fullArray) . '/';
        return file_get_contents($docroot . 'var/log/' . $filename);
    }
}
