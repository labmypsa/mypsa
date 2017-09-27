<?php
date_default_timezone_set('America/Phoenix');
ini_set('session.gc_maxlifetime', 7200);
session_start();

require 'config/App.php';
require 'config/Views.php';
require 'config/Imports.php';
require 'config/Validate.php';
require 'config/Dictionary.php';
require 'config/Responses.php';

spl_autoload_register(function($class){
    $class_path = ['config/', 'models/','controllers/'];
    foreach ($class_path as $directory) {
        $full_path = ($directory . $class . '.php');
        if (file_exists($full_path)) {
            require_once   $full_path;
        } 
    }
});


$controller = 'Index';
if (!isset($_REQUEST['c'])) {
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;
    $controller->Index();
} else {
    $controller = strtolower($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller();
    if (isset($_REQUEST['p'])) {
        call_user_func_array(array($controller, $accion), array($_REQUEST['p']));
    } else {
        call_user_func(array($controller, $accion));
    }
}
