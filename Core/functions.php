<?php

use Core\Response;
use Core\Database;
use Core\App;

function auth()
{
    $database = App::resolve(Database::class);
    $db = \Delight\Db\PdoDatabase::fromPdo($database->getPdo());
    $auth = new \Delight\Auth\Auth($db, NULL, 'admin_');

    return $auth;
}
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}
function roles()
{
    $roles = [
        \Delight\Auth\Role::ADMIN,
        \Delight\Auth\Role::AUTHOR,
        \Delight\Auth\Role::CONTRIBUTOR,
        \Delight\Auth\Role::DEVELOPER,
        \Delight\Auth\Role::MANAGER,
        \Delight\Auth\Role::MODERATOR,
        \Delight\Auth\Role::REVIEWER,
        \Delight\Auth\Role::SUBSCRIBER
    ];
    return $roles;
}

function getBreadcrumbs()
{
    // Get the full URL path
    $urlPath = $_SERVER['REQUEST_URI'];

    // Split the URL path into segments, removing empty parts
    $segments = array_filter(explode('/', $urlPath));

    // Initialize the base URL (protocol, host)
    $baseUrl = ($_SERVER['HTTPS'] ?? 'off') === 'on' ? 'https://' : 'http://';
    $baseUrl .= $_SERVER['HTTP_HOST'];

    $breadcrumbs = [];
    $path = '';

    // Loop through each segment to build the breadcrumb path
    foreach ($segments as $segment) {
        // Accumulate path up to this segment
        $path .= '/' . $segment;

        // Create a link for this segment
        $breadcrumbs[] = [
            'name' => ucfirst($segment), // Capitalize the segment
            'url' => $baseUrl . $path,
        ];
    }

    return $breadcrumbs;
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

function view($path, $attribute = []): void
{
    extract($attribute);
    require base_path('views/' . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}
function old($key, $default = '')
{
    return Core\Session::get('old')[$key] ?? $default;
}
