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
    private static $docroot = null;
    /**
     * @param TypeListInterface $logTypeList
     * @param StateInterface $logState
     * @param Pool $pool
     */
    public function __construct()
    {
        $unixFriendly = str_replace('\\', '/', __DIR__);
        $fullArray = explode('/', $unixFriendly);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        array_pop($fullArray);
        self::$docroot = implode('/', $fullArray)  . '/var/log/';
    }
    /**
     * @param  string
     * @return [type]
     */
    public function lineCount($filename = "system.log")
    {
        $filename = self::$docroot + $filename;
        $linecount = 0;
        $file = fopen($filename, "r");
        while (!feof($file)) {
            $line = fgets($file);
            $linecount++;
        }
        fclose($file);

        return $linecount;
    }
    /**
     * @param  string
     * @param  integer
     * @return [type]
     */
    public function fileSize($filename = "system.log", $precision = 2)
    {
        $bytes = fileSize(self::$docroot . $filename);
        $units = array("b", "kb", "mb", "gb", "tb");

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . " " . $units[$pow];
    }
    /**
     * Retrieve logs
     *
     * @param string $filename
     * @return string|null
     */
    public function retrieve($filename = "system.log", $lineCount = 100)
    {
        $path = self::$docroot . $filename;
        $handle = fopen($path, "r");

        while (!feof($handle)) {
            $out[] = trim(fgets($handle));
        }

        fclose($handle);
        return $out;
    }
}
