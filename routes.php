<?php
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

$router->get('/login', 'SessionController@create')->only('guest');
$router->post('/session', 'SessionController@store')->only('guest');
$router->delete('/session', 'SessionController@destroy')->only('auth');