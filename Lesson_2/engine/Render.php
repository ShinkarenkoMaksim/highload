<?php

namespace app\engine;

use app\interfaces\IRenderer;

class Render implements IRenderer
{
    public function renderTemplate($template, $params = [])
    {
        ob_start();
        extract($params);
        $templatePath = TEMPLATES_DIR . $template . ".php";
        include $templatePath;
        return ob_get_clean();
    }

    public static function renderView($template, $params = [])
    {
        ob_start();
        extract($params);
        $templatePath = TEMPLATES_DIR . $template . ".php";
        include $templatePath;
        return ob_get_clean();
    }
}