<?php

namespace Http\Controllers;

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Session;
use Core\Validation;
use Delight\Auth\AuthError;

class RegisterController
{
    protected $db;
    protected $auth;

    public function __construct()
    {

        $this->db = App::resolve(Database::class);
        $db = \Delight\Db\PdoDatabase::fromPdo($this->db->getPdo());
        $this->auth = new \Delight\Auth\Auth($db);
    }

    public function index(){
        view("/register/create.view.php", [
            'heading' => 'Home',
        ]);
    }
    public function store(){
        $errors = [];
        try {

            //delete anonymous nonymous callback function to get verify == 1 to database.
            $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
            });

            view('session/create.view.php',[
                'errors' => Session::get('errors')
            ]);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $errors['email'] = 'Please provide a valid email address.';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $errors['password'] = 'Please provide a password';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $errors['email'] = 'Email is exited';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $errors['email'] = 'Too many requests. Please try again later.';
        } catch (AuthError $e) {
            $errors['email'] = 'An unexpected error occurred. Please try again later.';
        }

        if (!empty($errors)) {
             view('register/create.view.php', [
                'errors' => $errors
            ]);
        }
    }
    public function forgetPassword(){
        view("/register/forgetPassword.view.php", [
            'heading' => 'Home',
        ]);
    }

}