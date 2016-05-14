<?php

namespace App\Utilities;

class Config
{
    public static function getDefaults()
    {
        $config = require __DIR__ . '/../../config/disks.conf.php';

        return $config;
    }
}