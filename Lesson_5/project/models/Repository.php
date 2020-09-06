<?php

namespace app\models;

use app\engine\Db;
use app\engine\Redis;
use app\models\entities\DataEntity;

/**
 * Class Model
 * @package app\models
 */
abstract class Repository extends Models
{
    protected $db;
    protected $redis;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->redis = Redis::getInstance();
    }

    public function getWhere($field, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `$field`=:$field";
        return $this->db->queryObject($sql, ["$field"=>$value], $this->getEntityClass());
    }

    public function getWhereRedis ($value)
    {
        return $this->redis->queryOne($value);
    }

    public function insert(DataEntity $entity)
    {
        $params = [];
        $columns = [];
        $tableName = $this->getTableName();
        foreach ($entity->state as $key => $value) {
            $params[":{$key}"] = $entity->$key;
            $columns[] = "`$key`";
        }
        $columns = implode(", ", $columns);
        $values = implode(", ", array_keys($params));

        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ($values);";

        $this->db->execute($sql, $params);
        $entity->id = $this->db->lastInsertId();
    }

    public function insertRedis(DataEntity $entity)
    {
        $params = [];
        foreach ($entity->state as $key => $value) {
            $params["$key"] = $entity->$key;
        }
        $this->redis->hmsetOne($entity->login, $params);
    }

    public function getAll()
    {
        return $this->db;
    }

}