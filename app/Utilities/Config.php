<?php

namespace App\Utilities;

class Config
{
    public static function get($index)
    {
        $config = require __DIR__ . '/../../config/config.php';
        return $config[$index];
    }
}