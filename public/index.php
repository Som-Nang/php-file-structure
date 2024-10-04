<?php

use Core\Session;

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
const BASE_PATH = __DIR__. '/../';

require BASE_PATH . 'Core/functions.php';

//Modify From :
//require base_path('Database.php');
//require base_path('Response.php');

//Modify To :
spl_autoload_register(function($class){

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);


    require base_path("{$class}.php");
});

require base_path('bootstrap.php');
$router = new Core\Router();

$routes = require base_path("router.php");

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->route($uri, $method);


Session::unflash();







