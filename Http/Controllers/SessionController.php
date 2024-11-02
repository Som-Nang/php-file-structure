<?php

namespace Http\Controllers;

use Http\Forms\LoginForm;
use Core\Authenticator;
use Core\Session;

class SessionController
{
    public function create()
    {
        view('session/create.view.php', [
            'errors' => Session::get('errors')
        ]);
    }

    public function store()
    {
        $Authenticator = new Authenticator();

        $form = LoginForm::validate($attributes = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        $signIn = $Authenticator->attempt(
            $attributes['email'],
            $attributes['password']
        );

        if (!$signIn) {
            $form->error('email',  $Authenticator->errors())->throw();
        }

        redirect('/dashboard');
    }

    public function destroy()
    {
        (new Authenticator)->logout();

        header('location: /');
        exit();
    }
}
