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

$router->get('/', 'controllers/index.php');
$router->get('/about', 'controllers/about.php');
$router->get('/contact', 'controllers/contact.php');
$router->get('/notes', 'controllers/notes/index.php');
$router->get('/note/show' ,'controllers/notes/show.php');
$router->get('/note/create' , 'controllers/notes/create.php');
$router->delete('/note/delete' , 'controllers/notes/destroy.php');


$router->get('/register', 'controllers/register/index.php');
$router->post('/register', 'controllers/register/store.php');