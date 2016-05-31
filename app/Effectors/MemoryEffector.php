<?php

namespace App\Effectors;

use App\Effectors\BaseEffector;
use System_Daemon;
use App\Utilities\MemoryUtils;
use App\Monitors\MemoryMonitor;
use App\Repositories\MemoryRepo;

class MemoryEffector extends BaseEffector
{
    public static function execute($dbOps)
    {
        $memInfo = MemoryMonitor::getMemoryDetails();

        System_Daemon::info('Memory - Total : %s , Used : %s , Free : %s',
            $memInfo['totalMemory']['disp'],$memInfo['usedMemory']['disp'],$memInfo['availableMemory']['disp']
        );

        if($dbOps) {
            $memoryRepo = new MemoryRepo;
            $memoryRepo->insertData($memInfo);
            //unset variable
            unset($memInfo);
        }
    }
}