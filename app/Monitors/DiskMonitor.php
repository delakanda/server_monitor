<?php

namespace App\Monitors;

use App\Monitors\Monitor;
use App\Utilities\Config;
use App\Utilities\DiskUtils;

class DiskMonitor extends Monitor
{
    public static function getDiskDetails()
    {
        $disks = Config::get('disks');
        $retArr = [];

        foreach($disks as $disk) {
            if(is_dir($disk)) {

                $diskUtil = new DiskUtils($disk);

                $retArr['free'] = $diskUtil->freeDiskSpace();
                $retArr['total'] = $diskUtil->totalDiskSpace();
                $retArr['used'] = $diskUtil->usedDiskSpace();

                return $retArr;

            } else {
                print_r($disk. ' - not a directory');
                return null;
            }
        }
    }
}