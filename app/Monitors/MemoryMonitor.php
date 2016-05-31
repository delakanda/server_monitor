<?php

namespace App\Monitors;

use App\Monitors\Monitor;
use App\Utilities\MemoryUtils;

class MemoryMonitor extends Monitor
{
    public static function getMemoryDetails()
    {
        return MemoryUtils::getSystemMemoryInfo();
    }
}