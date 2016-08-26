<?php

define("BASE_PATH", dirname(__DIR__) . "/");

class Loader
{
    private static function _load($file)
    {
        if(file_exists($file))
        {
            require_once $file;
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function init_view()
    {
        $page = isset($_GET["view"]) ? $_GET["view"] : Config::load("view_default");

        $view = BASE_PATH . "views/" . $page . ".php";

        self::_load($view);
    }

    public static function init_autoloader($class)
    {
        $dirs = array("config", "libraries", "models");

        foreach($dirs as $dir)
        {
            $file = BASE_PATH . $dir . "/" . $class . ".php";

            if(self::_load($file))
            {
                break;
            }
        }
    }
}

spl_autoload_register(array("Loader", "init_autoloader"));
