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

        foreach($disks as $key => $disk) {
            if(is_dir($disk)) {

                $diskUtil = new DiskUtils($disk);

                $retArr[$key]['path'] = $disk;
                $retArr[$key]['free'] = $diskUtil->freeDiskSpace();
                $retArr[$key]['total'] = $diskUtil->totalDiskSpace();
                $retArr[$key]['used'] = $diskUtil->usedDiskSpace();

            } else {
                print_r($disk. ' - not a directory');
                return null;
            }
        }

        return $retArr;
    }
}