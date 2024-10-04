<?php
use Core\App;
use Core\Database;
use Http\Forms\LoginForm;
use Core\Authenticator;
$db = App::resolve(Database::class);
$email = $_POST['email'];
$password = $_POST['password'];

    $form = LoginForm::validate($attributes = [
        'email' => $_POST['email'],
        'password'=> $_POST['password'],
    ]);

$signIn = (new Authenticator)->attempt(
    $attributes['email'], $attributes['password']
);
if(!$signIn){

    $form->error('email', 'No matching email address found! or password')->throw();

}
redirect('/');
