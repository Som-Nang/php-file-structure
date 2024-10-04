<?php
use Core\App;
use Core\Database;
use Core\Session;
use Http\Forms\LoginForm;
use Core\Authenticator;
$db = App::resolve(Database::class);
$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if($form->validation($email, $password)){
    $auth = new Authenticator();
    if($auth->attempt($email, $password)) {
        redirect('/');
    }else{

        $form->error('email', 'No matching email address found! or password');
    }
}

Session::flash('errors', $form->errors());
return redirect('/login');

//return view('session/create.view.php',[
//    'errors' => $form->errors()
//]);
//

