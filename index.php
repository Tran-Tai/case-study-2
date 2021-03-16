<?php

include_once("DB.php");

    $controller = $_GET["controller"] ?? NULL;
    $action = $_GET["action"] ?? NULL;

    if (!isset($controller)) {
        $controller = "persons";
        $action = "list";
    }

    function insertActive($controllerName)
    {
        $controller = $_GET["controller"];
        if ($controller == $controllerName)
        {
            echo "active";
        }
    }

    require_once("controllers/" . $controller . "_controller.php");

    $controllerName = ucwords($controller) . "Controller";

    $controller = new $controllerName;
    $controller->$action();
