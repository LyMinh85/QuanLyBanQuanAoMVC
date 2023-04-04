<?php

namespace Core;

use Helper;

class View
{
    public static function render($view, $args = [])
    {
        $rootPath = dirname(__DIR__);
        $file = "$rootPath/Views/$view.php";
        if (is_readable($file)) {
            extract($args, EXTR_SKIP);
            ob_start();
            require_once($file);
            $content = ob_get_clean();
            require_once("$rootPath/views/layout/index.php");
        } else {
            throw new \Exception("$file not found");
        }
    }
}
