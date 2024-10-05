<?php

//return [
//    '/' => 'controllers/index.php',
//    '/about' => 'controllers/about.php',
//    '/contact' => 'controllers/contact.php',
//    '/notes' => 'controllers/notes/index.php',
//    '/note/show' => 'controllers/notes/show.php',
//    '/note/delete' => 'controllers/notes/show.php',
//    '/note/create' => 'controllers/notes/create.php',
//];

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/notes', 'notes/index.php')->only('auth');
$router->get('/note/show' ,'notes/show.php');
$router->get('/note/create' , 'notes/create.php');
$router->post('/note/store' , 'notes/store.php');
$router->get('/note/edit', 'notes/edit.php');
$router->patch('/note', 'notes/update.php');
$router->delete('/note', 'notes/destroy.php');


$router->get('/register', 'register/index.php')->only('guest');
$router->post('/register', 'register/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');