<?php

namespace App\Utilities;

class Config
{
    public static function getDefaults()
    {
        $config = require __DIR__ . '/../../config/default.conf.php';

        return $config;
    }
}