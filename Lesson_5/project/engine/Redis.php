<?php


namespace app\engine;

use app\traits\TSingletone;
use Predis\Client as Predis;


class Redis
{

    private $config = [
        'scheme' => 'tcp',
        'host'   => '192.168.88.219',
        'port'   => 6379,
    ];

    use TSingletone;

    private $connection = null;

    private function getConnection() {
        if (is_null($this->connection)) {
            $this->connection =  new Predis($this->config);
        }
        return $this->connection;
    }

}