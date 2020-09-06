<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\UserredisRepository;
use app\engine\LoggerHandler;

class UserredisController extends Controller
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
            $userRepo = new UserredisRepository();
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
            $userRepo = new UserredisRepository();
            if (!$userRepo->auth($login, $pass)) {
                LoggerHandler::logInfo('Пароли при логине совпадают - ' . $login);
                die("Не верный пароль! <br> Пароль admin - 123, пароль user - 111");
            } else {
                LoggerHandler::logInfo('Пароль верный, успешный логин - ' . $login);
                $finish = 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
                var_dump($finish);
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