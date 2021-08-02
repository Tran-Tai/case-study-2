<?php
session_start();
include_once("DB.php");

    $controller = $_GET["controller"] ?? NULL;
    $action = $_GET["action"] ?? NULL;

    if (!isset($controller)) {
        $controller = "users";
        $action = "login";
    }

    function insertActive($controllerName)
    {
        $controller = $_GET["controller"] ?? "users";
        if ($controller == $controllerName)
        {
            echo "active";
        }
    }

    require_once("controllers/" . $controller . "_controller.php");

    $controllerName = ucwords($controller) . "Controller";

    $controller = new $controllerName;
    $controller->$action();
