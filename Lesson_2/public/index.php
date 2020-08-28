<?
session_start();

use app\engine\Render;
use app\engine\Request;
use app\models\repositories\UserRepository;

include $_SERVER['DOCUMENT_ROOT'] . "/../config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

$request = new Request();


//Разбираем строку запроса:
// первый аргумент - имя контроллера $controllerName,
// второй - имя действия контроллера $actionName,
// при отсутствии аргументов - вызываем контроллер IndexController
$controllerName = $request->getControllerName() ?: 'index';
$actionName = $request->getActionName();

//Если из строки запроса пришли 2 и более аргументов или имя контроллера "index", выполняем действие соответствующего контроллера
if ($actionName || $controllerName === "index") {
    //Формируем корректное имя контроллера
    $controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

    //Вызываем запрошенный метод запрошенного контроллера
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass(new Render());
        $controller->runAction($actionName);
    } else {
        echo "Не правильный контроллер";
    }
} else {
    //Если аргумент один - рендерим вьюшку без выполнения действий контроллеров
    echo Render::renderView($controllerName, ['isAuth' => (new UserRepository)->isAuth()]);
}


