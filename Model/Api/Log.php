<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\LogInterface;

/**
 * Class Log
 *
 * @package Springbot\Main\Api
 */
class Log extends AbstractModel implements LogInterface
{
    private static $docroot = null;

    /**
     * The constructor defines our docroot location.
     */
    public function __construct()
    {
        $unixFriendly = str_replace('\\', '/', __DIR__);
        $fullArray = explode('/', $unixFriendly);
        array_splice($fullArray, -5);
        self::$docroot = implode('/', $fullArray)  . '/var/log/';
    }

    /**
     * Returns the total line count for the specified file
     *
     * @param  string $filename
     *
     * @return int
     */
    public function lineCount($filename = "system")
    {
        $path = self::$docroot . $filename . '.log';
        if (! file_exists($path)) {
            return 'File not found: ' . self::$docroot . $filename;
        }
        $linecount = 0;
        $file = fopen($path, "r");
        while (! feof($file)) {
            $line = fgets($file);
            $linecount++;
        }
        fclose($file);

        return $linecount;
    }

    /**
     * Returns the total filesize of the specified log
     *
     * @param  string $filename
     * @param  integer $lineCount
     *
     * @return string
     */
    public function fileSize($filename = "system", $precision = 2)
    {
        if (! file_exists(self::$docroot . $filename . '.log')) {
            return 'File not found: ' . self::$docroot . $filename;
        }
        $bytes = fileSize(self::$docroot . $filename . '.log');
        $units = ["b", "kb", "mb", "gb", "tb"];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . " " . $units[$pow];
    }

    /**
     * Retrieve logs from the specified file. Will return the last 100 lines by default.
     * You may specify a specific line count to view.
     *
     * NOTES: The number of lines returned is counted backwards from the last line of the file.
     *
     * @param string $filename
     * @return string|null
     */
    public function retrieve($filename = "system", $lineCount = 100)
    {
        $path = self::$docroot . $filename . '.log';
        if (! file_exists($path)) {
            return 'File not found: ' . self::$docroot . $filename;
        }
        $total = $this->lineCount($filename);
        if ($total > $lineCount) {
            $startPoint = $total - $lineCount;
        } else {
            $startPoint = 0;
        }
        $handle = fopen($path, "r");
        $x = 0;
        while (! feof($handle)) {
            $line = trim(fgets($handle));
            if ($x >= $startPoint) {
                $out[] = $line;
            }
            $x++;
        }

        fclose($handle);
        return $out;
    }
}
