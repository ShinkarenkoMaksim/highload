<?php

namespace app\controllers;

use app\engine\Request;

class IndexController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('index');
    }
}