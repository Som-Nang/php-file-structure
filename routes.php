<?php
if (auth()->hasRole(\Delight\Auth\Role::ADMIN)) {
    $router->get('/user-management', 'UserManagement@index');
    $router->post('/user-management/store', 'UserManagement@store');
}




$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');
$router->get('/notes', 'NoteController@index')->only('auth');
$router->get('/note/show', 'NoteController@show');
$router->get('/note/create', 'NoteController@create');
$router->post('/note/store', 'NoteController@store');
$router->get('/note/edit', 'NoteController@edit');
$router->patch('/note', 'NoteController@update');
$router->delete('/note', 'NoteController@destroy');


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


$router->get('/login', 'SessionController@create')->only('guest');
$router->post('/session', 'SessionController@store')->only('guest');
$router->delete('/session', 'SessionController@destroy')->only('auth');
