<?php
if (auth()->hasRole(\Delight\Auth\Role::ADMIN)) {
    $router->get('/user-management', 'UserManagement@index');
    $router->post('/user-management/store', 'UserManagement@store');
    $router->get('/user-management/edit', 'UserManagement@edit');
    $router->post('/user-management/update', 'UserManagement@update');
    $router->post('/user-management/destroy', 'UserManagement@destroy');
    $router->post('/user-management/reset-user-password', 'UserManagement@reset');
}




$router->get('/dashboard', 'HomeController@index')->only('auth');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');



$router->get('/register', 'RegisterController@index')->only('guest');
$router->post('/register', 'RegisterController@store')->only('guest');
$router->get('/forget-password', 'RegisterController@forgetPassword')->only('guest');
$router->get('/confirmation', 'RegisterController@verifyPassword')->only('guest');
$router->post('/sendEmail', 'RegisterController@sendEmailForgetPass')->only('guest');
$router->get('/reset-password', 'RegisterController@resetPassword')->only('guest');
$router->post('/updatePassword', 'RegisterController@updatePassword')->only('guest');
$router->get('/verify-email', 'RegisterController@verifiEmail')->only('guest');

//not use
$router->get('/otp-verification', 'RegisterController@optVerification')->only('guest');


$router->get('/', 'SessionController@create')->only('guest');
$router->post('/session', 'SessionController@store')->only('guest');
$router->delete('/session', 'SessionController@destroy')->only('auth');
