<?php

namespace app\models;

use app\engine\Db;
use app\models\entities\DataEntity;

/**
 * Class Model
 * @package app\models
 */
abstract class Repository extends Models
{
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getWhere($field, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `$field`=:$field";
        return $this->db->queryObject($sql, ["$field"=>$value], $this->getEntityClass());
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


    public function getAll()
    {
        return $this->db;
    }

}