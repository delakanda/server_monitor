<?php

namespace App\Repositories;

use App\Repositories\DBRepo;

class DiskRepo extends DBRepo
{
    protected $table = 'disks';

    public function insertData($dataArr)
    {
        foreach($dataArr as $data) {

            $result = $this->capsule->table($this->table)->where('server_id',$this->getServerId())->where('disk_path',$data['path'])->first();

            if(empty($result)) {
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

                } else {
                    $this->capsule->table($this->table)->where('disk_id',$result->disk_id)->update([
                        'disk_total_space'          =>      $data['total']['raw'],
                        'disk_total_space_disp'     =>      $data['total']['disp'],
                        'disk_free_space'           =>      $data['free']['raw'],
                        'disk_free_space_disp'      =>      $data['free']['disp'],
                        'disk_used_space'           =>      $data['used']['raw'],
                        'disk_used_space_disp'      =>      $data['used']['disp'],
                    ]);
                }
            }
    }
}