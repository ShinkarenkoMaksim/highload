<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\UserRepository;
use app\engine\LoggerHandler;

class UserController extends Controller
{
    public function actionRegister() :void
    {
        LoggerHandler::logInfo('Запуск функции actionRegister()');
        $request = (new Request())->getParams();
        if (isset($request['submit'])) {
            LoggerHandler::logInfo('Начало выполнения блока if функции actionRegister()');
            $login = $request['login'];
            $pass = $request['pass'];
            $checkPass = $request['checkPass'];
            $userRepo = new UserRepository();
            if ($pass === $checkPass) {
                LoggerHandler::logInfo('Пароли при регистрации совпадают - ' . $login);
                $userRepo->register($login, $pass);
                LoggerHandler::logInfo('Регистрация выполнена - ' . $login);
                header("Location: /");
            } else
                LoggerHandler::logInfo('Пароли не совпали - ' . $login);
                die("Пароли не совпадают");
        }
        LoggerHandler::logError('Ошибка выполнения функции actionRegister()');
    }

    public function actionLogin() :void
    {
        $start = microtime(true);
        LoggerHandler::logInfo('Запуск функции actionLogin()');
        $request = (new Request())->getParams();
        if (isset($request['submit'])) {
            LoggerHandler::logInfo('Начало выполнения блока if функции actionLogin()');
            $login = $request['login'];
            $pass = $request['pass'];
            $userRepo = new UserRepository();
            if (!$userRepo->auth($login, $pass)) {
                LoggerHandler::logInfo('Пароли при логине совпадают - ' . $login);
                die("Не верный пароль! <br> Пароль admin - 123, пароль user - 111");
            } else {
                LoggerHandler::logInfo('Пароль верный, успешный логин - ' . $login);
                echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
                header("Location: /");
            }
            exit();
        }
        LoggerHandler::logError('Ошибка выполнения функции actionRegister()');
    }

    public function actionLogout() :void
    {
        session_destroy();
        header("Location: /");
        exit();
    }

}