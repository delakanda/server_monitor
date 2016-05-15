<?php

namespace App\Repositories;

use App\Utilities\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use System_Daemon;

class DBRepo
{
    protected $config;
    protected $capsule;
    protected $server;
    protected $serverTable = 'servers';

    public function __construct()
    {
        $this->config = Config::get('db');
        $this->capsule = new Capsule;
        $this->capsule->addConnection($this->config);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        $this->server = Config::get('server');
        $result = $this->capsule->table($this->serverTable)->where('server_host_ip',$this->server)->get();

        if(empty($result)) {

            System_Daemon::info('Inserting new record for server : %s',$this->server);

            $data = [ ['server_host_ip' => $this->server] ];
            $this->capsule->table($this->serverTable)->insert($data);

            System_Daemon::info('Insertion successful');
        }
    }

    protected function getServerId()
    {
        $result = $this->capsule->table($this->serverTable)->where('server_host_ip',$this->server)->first();
        return $result->server_id;
    }
}