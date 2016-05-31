<?php namespace App\Utilities;

class MemoryUtils
{
    static $memoryFilePath = '/proc/meminfo';
    static $totalMemIndex = 'MemTotal';
    static $freeMemIndex = 'MemFree';
    static $availableMemIndex = 'MemAvailable';

    public function __construct()
    {

    }

    public function getSystemMemoryInfo()
    {
        $memoryInfoData = [];

        $data = explode("\n", file_get_contents("/proc/meminfo"));

        $meminfo = array();

        foreach ($data as $line) {
            list($key, $val) = explode(":", $line);
            $meminfo[$key] = trim(str_replace("kB", "", $val));
        }

        $memoryInfoData['totalMemory'] = ['disp' => self::formatKBToGBDisp($meminfo[self::$totalMemIndex]), 'raw' => self::formatKBToGB($meminfo[self::$totalMemIndex])];
        $memoryInfoData['availableMemory'] = ['disp' => self::formatKBToGBDisp($meminfo[self::$availableMemIndex]) ,'raw' => self::formatKBToGB($meminfo[self::$availableMemIndex])];
        $memoryInfoData['usedMemory'] = [
            'disp' => self::formatKBToGBDisp($meminfo[self::$totalMemIndex] - $meminfo[self::$availableMemIndex]),
            'raw'  => self::formatKBToGB($meminfo[self::$totalMemIndex] - $meminfo[self::$availableMemIndex]),
        ];

        return $memoryInfoData;
    }

    public function formatKBToGB($kilobyteData)
    {
        return $kilobyteData / 1000000;
    }

    public function formatKBToGBDisp($kilobyteData)
    {
        return $kilobyteData / 1000000 . " GB";
    }

}