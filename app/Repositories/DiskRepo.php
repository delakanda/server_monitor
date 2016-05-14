<?php

namespace App\Repositories;

use App\Repositories\DBRepo;

class DiskRepo extends DBRepo
{
    protected $table = 'disks';

    public function insertData($data)
    {
        $result = $this->capsule->table($this->table)->where('server_host_ip',$this->server)->get();
    }
}