<?php
//dd($_POST);
use Core\App;
use Core\Database;
use Core\Validation;

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if(!Validation::email($email))
{
    $errors['email'] = 'Please enter a valid email address';
}

if(!Validation::string($password, 7, 255))
{
    $errors['error'] = 'Please provide a password of at least seven characters';
}

if(!Validation::string($name, 7, 255))
{
    $errors['error'] = 'Please provide a name of at least seven characters';
}

if(!empty($errors))
{
    return view("/register/create.view.php",
    [
        'errors' => $errors,

    ]);
}

$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM user where email = :email', [
    'email' => $email
])->find();

if ($user){
    header('location: /register');
}else{
    $db->query('INSERT INTO user(name, email, password) VALUES (:name, :email, :password)', [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);

    $_SESSION['user'] = [
        'name' => $name
    ];

    header('location: /');
    exit();

}

