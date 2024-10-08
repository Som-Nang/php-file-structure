<?php

namespace Http\Controllers;

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\MailSender;
use Core\Session;
use Core\Validation;
use Delight\Auth\AuthError;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RegisterController
{
    protected $db;
    protected $auth;

    protected $selector;
    protected $token;

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
                $url = 'https://www.example.com/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $body = MailSender::verifyMailHtml($_POST['username'], '<p>
                        Please click below link to verify your password</p> </br> 
                        <a href='.$url.'> ->  '. $url .'</a>
                        ');
                MailSender::sentMail($_POST['email'], 'Test', $body);
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
        view("register/forgetPassword.view.php", [
            'heading' => 'Forget Password',
        ]);
    }

    public function sendEmailForgetPass(){
        $errors = [];
        try {
            $this->auth->forgotPassword($_POST['email'], function ($selector, $token) {
                $url = 'http://demo.test/reset-password?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $body = MailSender::verifyMailHtml($_POST['email'], '<p>
                        Please click below link to reset your password</p> </br>
                        <a href='.$url.'> ->  '. $url .'</a>
                        ');
                MailSender::sentMail($_POST['email'], 'Reset Password', $body);
            });

            view("mail-confirmation.view.php", [
                'content' => 'Please check your email to reset password',
            ]);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $errors['email'] = 'Please provide a valid email address.';
        }
        catch (\Delight\Auth\EmailNotVerifiedException|\Delight\Auth\TooManyRequestsException $e) {
            $errors['email'] = 'Too many requests. Please try again later.';
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            $errors['email'] = 'Email not verify';
        } catch (AuthError $e) {
            $errors['email'] = 'An unexpected error occurred. Please try again later.';
        }
        if (!empty($errors)) {
            view("register/forgetPassword.view.php", [
                'errors' => $errors
            ]);
        }

    }

    public function resetPassword(){
        $errors = [];
        try {
            $this->auth->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);
            view("register/resetPassword.view.php", [
                'heading' => 'Update Password',
            ]);
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $errors['error'] = 'Invalid token';
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            $errors['error'] = 'Token expired';
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            $errors['error'] = 'Password reset is disabled';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $errors['error'] = 'Too many requests';
        } catch (AuthError $e) {
            $errors['error'] = 'An unexpected error occurred. Please try again later.';
        }

        if (!empty($errors)) {
            view("register/forgetPassword.view.php", [
                'errors' => $errors
            ]);
        }
    }

    public function updatePassword(){
       $confirmPassword = $_POST['confirm-password'];
       $password = $_POST['password'];
       $errors = ['password not match'];
       if($confirmPassword === $password)
       {
           $errors = [];

           try {
               $this->auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);

               echo 'Password has been reset';
           }
           catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
               die('Invalid token');
           }
           catch (\Delight\Auth\TokenExpiredException $e) {
               die('Token expired');
           }
           catch (\Delight\Auth\ResetDisabledException $e) {
               die('Password reset is disabled');
           }
           catch (\Delight\Auth\InvalidPasswordException $e) {
               die('Invalid password');
           }
           catch (\Delight\Auth\TooManyRequestsException $e) {
               die('Too many requests');
           } catch (AuthError $e) {
           }

       }

        if (!empty($errors)) {
            view("register/resetPassword.view.php", [
                'errors' => $errors
            ]);
        }

    }

    public function verifyPassword(){
        view("mail-confirmation.view.php", [
            'heading' => 'Verify',
            'content' => 'Please check your email to reset password',
        ]);
    }

}