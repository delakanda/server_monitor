<?php

namespace App\Repositories;

use App\Repositories\DBRepo;
use System_Daemon;

class MemoryRepo extends DBRepo
{
    protected $table = 'server_memories';

    public function insertData($data)
    {
        $result = $this->capsule->table($this->table)->where('server_id',$this->getServerId())->first();

        if(empty($result)) {
            System_Daemon::info('Inserting new memory record ');

            $dbData = [[
                'total_memory_disp'                 =>      $data['totalMemory']['disp'],
                'total_memory'                      =>      $data['totalMemory']['raw'],
                'available_memory_disp'             =>      $data['availableMemory']['disp'],
                'available_memory'                  =>      $data['availableMemory']['raw'],
                'used_memory_disp'                  =>      $data['usedMemory']['disp'],
                'used_memory'                       =>      $data['usedMemory']['raw'],
                'server_id'                         =>      $this->getServerId()
            ]];
            $this->capsule->table($this->table)->insert($dbData);

            System_Daemon::info('Insertion successful');
        } else {

            System_Daemon::info('Updating memory details');

            $this->capsule->table($this->table)->where('server_memory_id',$result->server_memory_id)->update([
                'total_memory_disp'                 =>      $data['totalMemory']['disp'],
                'total_memory'                      =>      $data['totalMemory']['raw'],
                'available_memory_disp'             =>      $data['availableMemory']['disp'],
                'available_memory'                  =>      $data['availableMemory']['raw'],
                'used_memory_disp'                  =>      $data['usedMemory']['disp'],
                'used_memory'                       =>      $data['usedMemory']['raw']
            ]);

            System_Daemon::info('Update successful');
        }
    }
}