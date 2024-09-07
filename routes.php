<?php



$routes = require "router.php";

function routeController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}
function abort($code = 404)
{
    http_response_code(404);

    require "view/{$code}.php";

    die();
}
routeController($uri, $routes);

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
