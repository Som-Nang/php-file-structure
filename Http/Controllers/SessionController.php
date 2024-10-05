<?php

namespace Http\Controllers;

use Http\Forms\LoginForm;
use Core\Authenticator;
use Core\Session;
class SessionController
{
    public function create()
    {
        view('session/create.view.php',[
            'errors' => Session::get('errors')
        ]);
    }

    public function store()
    {
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

    }

    public function destroy()
    {
        (new Authenticator)->logout();

        header('location: /');
        exit();
    }
}