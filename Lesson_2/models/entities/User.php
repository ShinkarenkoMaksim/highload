<?php

namespace app\models\entities;

class User extends DataEntity
{
    public $id;
    public $login;
    public $passwordHash;

    public $state = [
        'login' => true,
        'passwordHash' => true,
    ];

    /**
     * User constructor.
     * @param $login
     * @param $passwordHash
     * @param $id
     */
    public function __construct($login = null, $passwordHash = null, $id = null)
    {
        $this->id = $id;
        $this->login = $login;
        $this->passwordHash = $passwordHash;

    }

    public function isAuth()
    {
        return isset($_SESSION['login']) ? true : false;
    }
}