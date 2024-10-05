<?php
use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value): bool
{
    if ((strpos($_SERVER['REQUEST_URI'], $value, 0) !== false) && (strlen($value) > 0)) {
        return true;
    }
    return false;
}

 function abort($code = 404)
{
    http_response_code(404);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }
}

function base_path($path): string
{
    return BASE_PATH . $path;
}

function view($path, $attribute = []):void
{
    extract($attribute);
    require base_path('views/'. $path);
}

function redirect($path){
    header("location: {$path}");
    exit();
}
function old($key, $default = ''){
    return Core\Session::get('old')[$key] ?? $default;
}