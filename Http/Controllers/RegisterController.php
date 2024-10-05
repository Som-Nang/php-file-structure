<?php

namespace Http\Controllers;

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Session;
use Core\Validation;

class RegisterController
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function index(){
        view("/register/create.view.php", [
            'heading' => 'Home',
        ]);
    }
    public function store(){
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
             view('register/create.view.php', [
                'errors' => $errors
            ]);
        }


        $user = $this->db->query('select * from user where email = :email', [
            'email' => $email,
        ])->find();

        if ($user) {
            header('location: /register');
            exit();
        } else {
            $this->db->query('INSERT INTO user(name, email, password) VALUES(:name, :email, :password)', [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
           
            view('session/create.view.php',[
                'errors' => Session::get('errors')
            ]);
        }

    }
}