<?php

namespace App\Utilities;

class DiskUtils
{
    private $directory;

    public function __construct($dir)
    {
        $this->directory = $dir;
    }

    public function totalDiskSpace()
    {
        $diskSpace = disk_total_space($this->directory);

        return [ 'disp' => $this->getUnits($diskSpace), 'raw' => $diskSpace ];
    }

    public function freeDiskSpace()
    {
        $diskSpace = disk_free_space($this->directory);

        return [ 'disp' => $this->getUnits($diskSpace), 'raw' => $diskSpace ];
    }

    public function usedDiskSpace()
    {
        $diskSpace = disk_total_space($this->directory) - disk_free_space($this->directory);

        return [  'disp' => $this->getUnits($diskSpace), 'raw' => $diskSpace  ];
    }

    protected function getUnits($bytes) {

        $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');

        $exp = floor(log($bytes)/log(1024));

        return sprintf('%.2f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
    }

    // private function getUnits($bytes) {
    //     $units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
    //
    //     for($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++ ) {
    //         $bytes /= 1024;
    //     }
    //     return round($bytes, 1).' '.$units[$i];
    // }
}