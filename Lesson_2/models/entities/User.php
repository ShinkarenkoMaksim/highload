<?php

namespace app\models\entities;

class User extends DataEntity
{
    public $id;
    public $login;
    public $pass;


    /**
     * User constructor.
     * @param $login
     * @param $pass
     * @param $id
     */
    public function __construct($login = null, $pass = null, $id = null)
    {
        $this->id = $id;
        $this->login = $login;
        $this->pass = $pass;

    }

    public function isAuth()
    {
        return isset($_SESSION['login']) ? true : false;
    }
}