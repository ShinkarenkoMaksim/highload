<?php

namespace app\models\repositories;

use app\models\entities\User;
use app\models\Repository;

class UserRepository extends Repository
{
    public function auth($login, $pass)
    {
        $user = $this->getWhere('login', $login);
        if ($user && $pass == $user->pass) {
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $user->id;
            return true;
        }
        return false;
    }

    public function register($login, $pass)
    {
        if (!$this->getWhere('login', $login)) {
            $this->insert(new User($login, $pass));
            return true;
        }
        die("Такой пользователь уже существует");
    }

    public function isAuth()
    {
        return isset($_SESSION['login']) ? true : false;
    }

    public static function isAuthStatic()
    {
        return isset($_SESSION['login']) ? true : false;
    }

    public function getName()
    {
        return $this->isAuth() ? $_SESSION['login'] : "Guest";
    }

    public function getId()
    {
        return $_SESSION['id'];
    }

}