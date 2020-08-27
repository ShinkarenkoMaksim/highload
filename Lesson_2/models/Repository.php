<?php

namespace app\models;

use app\models\entities\DataEntity;

/**
 * Class Model
 * @package app\models
 */
abstract class Repository extends Models
{
    protected $bd = [];

    public function __construct()
    {
        $file = file("../data/bd.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file as $str) {
            array_push($this->bd, json_decode($str));
        }
    }

    public function getWhere($field, $value)
    {
        foreach ($this->bd as $item) {
            if ($item->$field === $value)
                return $item;
        }
        return false;
    }

    public function insert(DataEntity $entity)
    {
        $entity->id = count($this->bd);
        $file = fopen("../data/bd.txt", "a+");
        fwrite($file, json_encode($entity) . PHP_EOL);
        fclose($file);
    }

    public function getAll()
    {
        return $this->bd;
    }

}