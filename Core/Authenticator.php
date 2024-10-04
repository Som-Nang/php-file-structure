<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password){
        $user = App::resolve(Database::class)->query('select * from user where email = :email', [
            'email' => $email
        ])->find();

        if($user){
            if (password_verify($password, $user['password'])){
                $this->login([
                    'email' => $email,
                    'user_name' => $user['name']
                ]);

                return true;
            }
        }

        return false;
    }
    public function login($user){
        $_SESSION['user'] = [
            'email' =>$user['email'],
            'user_name' => $user['user_name']
        ];

        session_regenerate_id();
    }

    public function logout(){
        Session::destroy();
    }
}