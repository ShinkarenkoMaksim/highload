<?
session_start();

use app\engine\Render;
use app\engine\Request;
use app\models\repositories\UserRepository;

include $_SERVER['DOCUMENT_ROOT'] . "/../config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

$request = new Request();

$controllerName = $request->getControllerName() ?: 'index';
$actionName = $request->getActionName();

if ($actionName || $controllerName === "index") {
    $controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass(new Render());
        $controller->runAction($actionName);
    } else {
        echo "Не правильный контроллер";
    }
} else
    echo Render::renderView($controllerName, ['isAuth' => UserRepository::isAuthStatic()]);


