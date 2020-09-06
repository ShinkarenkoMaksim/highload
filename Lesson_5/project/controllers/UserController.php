<?php

namespace app\controllers;

use app\engine\Render;
use app\engine\Request;
use app\models\repositories\UserRepository;
use app\engine\LoggerHandler;

class UserController extends Controller
{
    public function actionRegister() :void
    {
        $start = microtime(true);
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
                $finish = 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
                var_dump($finish);
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
                LoggerHandler::logInfo('Пароли при логине не совпадают - ' . $login);
                die("Неверный пароль!");
            } else {
                LoggerHandler::logInfo('Пароль верный, успешный логин - ' . $login);
                $finish = 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
                var_dump($finish);
                //header("Location: /");
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