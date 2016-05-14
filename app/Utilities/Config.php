<?php

namespace App\Utilities;

class Config
{
    public static function get($file)
    {
        return require __DIR__ . '/../../config/'.$file.'.conf.php';
    }
}