<?php

namespace app\models\repositories;

use app\models\entities\User;
use app\models\Repository;
use app\engine\LoggerHandler;

class UserredisRepository extends Repository
{
    public function auth($login, $pass)
    {
        LoggerHandler::logInfo('Запуск функции auth()');
        $user = $this->getWhereRedis($login);
        if ($user && password_verify($pass, $user["passwordHash"])) {
            $_SESSION['login'] = $login;
            return true;
        }
        LoggerHandler::logInfo('Аутентификация не удалась');
        return false;
    }

    public function register($login, $pass)
    {
        LoggerHandler::logInfo('Запуск функции register()');
        if (!$this->getWhereRedis($login)) {
            $this->insertRedis(new User($login, password_hash($pass, PASSWORD_DEFAULT)));
            return true;
        }
        LoggerHandler::logInfo('Попытка создать существующего пользователя ' . $login);
        die("Такой пользователь уже существует");
    }

    public function getName()
    {
        return (new User)->isAuth() ? $_SESSION['login'] : "Guest";
    }

    public function getEntityClass () {
        return User::class;
    }

}