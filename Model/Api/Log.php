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
    public function __construct() {
        #
    }

    /**
     * Retrieve logs
     *
     * @param string $filename
     * @return string|null
     */
    public function retrieve($filename="system.log")
    {
        return array('success');
    }
}
