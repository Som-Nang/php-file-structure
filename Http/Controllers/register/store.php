
<?php
use Core\App;
use Core\Database;
use Core\Validation;
$db = App::resolve(Database::class);
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$errors = [];

if (!Validation::string($name, 7, 255)) {
    $errors['name'] = 'Please provide a valid name.';
}

if (!Validation::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}
if (!Validation::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}
if (! empty($errors)) {
    return view('register/create.view.php', [
        'errors' => $errors
    ]);
}
$user = $db->query('select * from user where email = :email', [
    'email' => $email,
])->find();
if ($user) {
    header('location: /');
    exit();
} else {
    $db->query('INSERT INTO user(name, email, password) VALUES(:name, :email, :password)', [
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);
    login($user);
    header('location: /');
    exit();
}

