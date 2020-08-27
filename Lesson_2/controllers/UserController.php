<?php


namespace app\controllers;

use app\engine\Request;
use app\models\repositories\UserRepository;

class UserController extends Controller
{
    public function actionRegister()
    {
        $request = (new Request())->getParams();
        if (isset($request['submit'])) {
            $login = $request['login'];
            $pass = $request['pass'];
            $checkPass = $request['checkPass'];
            $userRepo = new UserRepository();
            if ($pass === $checkPass) {
                $userRepo->register($login, $pass);
                header("Location: /");
            } else
                die("Пароли не совпадают");
        }
    }

    public function actionLogin()
    {
        $request = (new Request())->getParams();
        if (isset($request['submit'])) {
            $login = $request['login'];
            $pass = $request['pass'];
            $userRepo = new UserRepository();
            if (!$userRepo->auth($login, $pass)) {
                die("Не верный пароль! <br> Пароль admin - 123, пароль user - 111");
            } else {
                header("Location: /");
            }
            exit();
        }
    }

    public function actionLogout()
    {
        session_destroy();
        setcookie("hash", null, 0, "/");
        header("Location: /");
        exit();
    }

}