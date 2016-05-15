<?php

namespace App\Effectors;

use App\Effectors\BaseEffector;
use App\Monitors\DiskMonitor;
use App\Repositories\DiskRepo;
use System_Daemon;

class DiskEffector extends BaseEffector
{
    public static function execute($dbOps)
    {
        $diskDetails = DiskMonitor::getDiskDetails();

        foreach($diskDetails as $disk) {
            System_Daemon::info('Disk Space (%s) - Total : %s , Used : %s , Free : %s',
                $disk['path'],$disk['total']['disp'],$disk['used']['disp'],$disk['free']['disp']
            );
        }

        if($dbOps) {
            $diskRepo = new DiskRepo;
            $diskRepo->insertData($diskDetails);
            //unset variable
            unset($diskRepo);
        }
    }
}