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

        $result = $this->capsule->table($this->serverTable)->where('server_host_ip',$this->server['host_ip'])->get();

        if(empty($result)) {

            System_Daemon::info('Inserting new record for server : %s',$this->server);

            $data = [ ['server_host_ip' => $this->server['host_ip'],'server_name'=>$this->server['name']] ];
            $this->capsule->table($this->serverTable)->insert($data);

            System_Daemon::info('Insertion successful');
        }
    }

    protected function getServerId()
    {
        $result = $this->capsule->table($this->serverTable)->where('server_host_ip',$this->server['host_ip'])->first();
        return $result->server_id;
    }

    public static function testDBConnection()
    {
        $retVal = false;

        $dbConfig = Config::get('db');

        System_Daemon::info('Testing DB Connection...');

        try{
            $dbConn = new \pdo( $dbConfig['driver'].':host='.$dbConfig['host'].';dbname='.$dbConfig['database'],
                            $dbConfig['username'],
                            $dbConfig['password'],
                            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $retVal = true;
        }
        catch(\PDOException $ex){
            $retVal = false;
        }

        return $retVal;
    }
}
