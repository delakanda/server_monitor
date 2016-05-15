<?php

namespace App\Repositories;

use App\Repositories\DBRepo;
use System_Daemon;

class DiskRepo extends DBRepo
{
    protected $table = 'disks';

    public function insertData($dataArr)
    {
        foreach($dataArr as $data) {

            $result = $this->capsule->table($this->table)->where('server_id',$this->getServerId())->where('disk_path',$data['path'])->first();

            if(empty($result)) {

                System_Daemon::info('Inserting new record for path : %s',$data['path']);

                $dbData = [[
                    'disk_path'                 =>      $data['path'],
                    'disk_total_space'          =>      $data['total']['raw'],
                    'disk_total_space_disp'     =>      $data['total']['disp'],
                    'disk_free_space'           =>      $data['free']['raw'],
                    'disk_free_space_disp'      =>      $data['free']['disp'],
                    'disk_used_space'           =>      $data['used']['raw'],
                    'disk_used_space_disp'      =>      $data['used']['disp'],
                    'server_id'                 =>      $this->getServerId()
                ]];
                $this->capsule->table($this->table)->insert($dbData);

                System_Daemon::info('Insertion successful');

                } else {

                    System_Daemon::info('Updating disk details for path : %s',$data['path']);

                    $this->capsule->table($this->table)->where('disk_id',$result->disk_id)->update([
                        'disk_total_space'          =>      $data['total']['raw'],
                        'disk_total_space_disp'     =>      $data['total']['disp'],
                        'disk_free_space'           =>      $data['free']['raw'],
                        'disk_free_space_disp'      =>      $data['free']['disp'],
                        'disk_used_space'           =>      $data['used']['raw'],
                        'disk_used_space_disp'      =>      $data['used']['disp'],
                    ]);

                    System_Daemon::info('Update successful');
                }
            }
    }
}