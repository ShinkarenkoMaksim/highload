<?php


namespace app\controllers;

use app\engine\Render;
use app\interfaces\IRenderer;
use app\models\repositories\UserRepository;

abstract class Controller
{
    private $action;
    private $defaultAction = "index";
    private $layout = 'main';
    private $renderer;

    /**
     * Controller constructor.
     * @param $renderer
     */
    public function __construct(IRenderer $renderer)
    {
        $this->renderer = $renderer;
    }


    public function runAction($action = null)
    {
        $this->action = $action ?: $this->defaultAction;
        $method = "action" . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            echo "404";
        }
    }

    public function render($template, $params = [])
    {
        if ((new UserRepository())->isAuth()) {
            $id = (new UserRepository())->getId();
            $field = 'user_id';
        } else {
            $id = session_id();
            $field = 'session_id';
        }
        return $this->renderTemplate("layouts/{$this->layout}", [
            'content' => $this->renderTemplate($template, $params),
            'auth' => (new UserRepository())->isAuth(),
            'username' => (new UserRepository())->getName(),
        ]);
    }

    public function renderTemplate($template, $params = [])
    {
        return $this->renderer->renderTemplate($template, $params);
    }

}