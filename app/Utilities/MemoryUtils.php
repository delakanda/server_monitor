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

    public static function getSystemMemoryInfo()
    {
        $memoryInfoData = [];

        // $data = explode("\n", file_get_contents("/proc/meminfo"));
        //
        // $meminfo = array();
        //
        // foreach ($data as $line) {
        //     list($key, $val) = explode(":", $line);
        //     $meminfo[$key] = trim(str_replace("kB", "", $val));
        // }

        $free = shell_exec('free');
    	$free = (string)trim($free);
    	$free_arr = explode("\n", $free);
    	$mem = explode(" ", $free_arr[1]);
    	$mem = array_filter($mem);
    	$mem = array_merge($mem);
    	$memory_usage = $mem[2]/$mem[1]*100;

        $memoryInfoData['totalMemory'] = ['disp' => self::formatKBToGBDisp($mem[1]), 'raw' => self::formatKBToGB($mem[1])];
        $memoryInfoData['usedMemory'] = ['disp' => self::formatKBToGBDisp($mem[2]) ,'raw' => self::formatKBToGB($mem[2])];
        $memoryInfoData['availableMemory'] = [
            'disp' => self::formatKBToGBDisp($mem[1] - $mem[2]),
            'raw'  => self::formatKBToGB($mem[1] - $mem[2]),
        ];

        return $memoryInfoData;
    }

    public static function formatKBToGB($kilobyteData)
    {
        return $kilobyteData / 1000000;
    }

    public static function formatKBToGBDisp($kilobyteData)
    {
        return number_format(($kilobyteData / 1000000),2) . " GB";
    }

}