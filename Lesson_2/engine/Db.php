<?php


namespace app\engine;

use app\traits\TSingletone;

class Db
{
    private $config = [
        'driver' => 'mysql',
        'host' => '192.168.88.219',
        'login' => 'highload',
        'password' => 'password',
        'database' => 'highload',
        'charset' => 'utf8'
    ];

    use TSingletone;

    private $connection = null;

    private function getConnection() {
        if (is_null($this->connection)) {
            $this->connection =  new \PDO($this->prepareDSNstring(),
                $this->config['login'],
                $this->config['password']);

            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->connection;
    }

    private function prepareDSNstring() {
        return sprintf('%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    private function query($sql, $params) {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function queryObject($sql, $params, $class) {
        $pdoStatement = $this->query($sql, $params);
        $pdoStatement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        return $pdoStatement->fetch();
    }

    public function execute($sql, $params = []) {
        $this->query($sql, $params);
        return true;
    }

    public function queryOne($sql, $params = []) {
        return $this->queryAll($sql, $params)[0];
    }

    public function queryAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

}