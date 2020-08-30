<?php

namespace app\models\repositories;

use app\models\entities\User;
use app\models\Repository;
use app\engine\LoggerHandler;

class UserRepository extends Repository
{
    public function getTableName() {
        return 'users';
    }

    public function auth($login, $pass)
    {
        LoggerHandler::logInfo('Запуск функции auth()');
        $user = $this->getWhere('login', $login);
        if ($user && password_verify($pass, $user->passwordHash)) {
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $user->id;
            return true;
        }
        LoggerHandler::logInfo('Аутентификация не удалась');
        return false;
    }

    public function register($login, $pass)
    {
        LoggerHandler::logInfo('Запуск функции register()');
        if (!$this->getWhere('login', $login)) {
            $this->insert(new User($login, password_hash($pass, PASSWORD_DEFAULT)));
            return true;
        }
        LoggerHandler::logInfo('Попытка создать существующего пользователя ' . $login);
        die("Такой пользователь уже существует");
    }

    public function getName()
    {
        return (new User)->isAuth() ? $_SESSION['login'] : "Guest";
    }

    public function getId()
    {
        return $_SESSION['id'];
    }

    public function getEntityClass () {
        return User::class;
    }

}