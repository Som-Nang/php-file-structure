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

    public function selector(){
        return $this->selector = $_POST['selector'];
    }

    public function token(){
        return $this->token = $_POST['token'];
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
                $url = 'http://demo.test/verify-email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $body = MailSender::verifyMailHtml($_POST['username'], '<p>
                        Please click below link to verify your password</p> </br> 
                        <a href='.$url.'> ->  '. $url .'</a>
                        ');
                MailSender::sentMail($_POST['email'], 'Test', $body);
            });

            view("mail-confirmation.view.php", [
                'heading' => 'Verify',
                'content' => 'Please check your email to verify',
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

    public function verifiEmail(){

        $errors = [];
        try {
            $this->auth->confirmEmailAndSignIn($_GET['selector'], $_GET['token']);

            $Authenticator = new Authenticator();
            $Authenticator->login([
                'email' =>  $this->auth->getEmail(),
                'user_name' =>  $this->auth->getUsername(),
                'userID' =>  $this->auth->getUserId()
            ]);

            redirect('/');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $errors['error'] = 'Invalid token';
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            $errors['error'] = 'Token expired';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $errors['error'] = 'Email address already exists';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $errors['error'] = 'Too many requests';
        } catch (AuthError $e) {
            $errors['error'] = 'An unexpected error occurred. Please try again later.';
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
                'selector' => $_GET['selector'],
                'token' => $_GET['token'],
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
        $Authenticator = new Authenticator();
       $confirmPassword = $_POST['confirm-password'];
       $password = $_POST['password'];
       $errors = ['password not match'];
       if($confirmPassword === $password)
       {
           $errors = [];
           try {
               $this->auth->resetPasswordAndSignIn($this->selector(), $this->token(), $_POST['password']);

               // Assign Session
               $Authenticator->login([
                   'email' =>  $this->auth->getEmail(),
                   'user_name' =>  $this->auth->getUsername(),
                   'userID' =>  $this->auth->getUserId()
               ]);

               redirect('/');
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
           catch (\Delight\Auth\InvalidPasswordException $e) {
               $errors['error'] = 'Invalid password';
           }
           catch (\Delight\Auth\TooManyRequestsException $e) {
               $errors['error'] = 'Too many requests';
           } catch (AuthError $e) {
               $errors['error'] = 'An unexpected error occurred. Please try again later.';
           }

       }
        if (!empty($errors)) {
            header('location: /reset-password?selector='. $this->selector(). '&token='. $this->token());
            exit();
        }

    }

    public function verifyPassword(){
        view("mail-confirmation.view.php", [
            'heading' => 'Verify',
            'content' => 'Please check your email to reset password',
        ]);
    }

}