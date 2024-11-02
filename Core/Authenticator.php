<?php

namespace Core;

use Core\Database;

class Authenticator
{

    protected $db;
    protected $auth;

    protected string $errors = '';
    public function __construct()
    {
        $this->db = App::resolve(Database::class);

        $db = \Delight\Db\PdoDatabase::fromPdo($this->db->getPdo());
        $this->auth = new \Delight\Auth\Auth($db, NULL, 'admin_');
    }


    public function attempt($email, $password)
    {
        try {
            $this->auth->login($email, $password);

            $user = App::resolve(Database::class)->query('select * from admin_users where email = :email', [
                'email' => $email
            ])->find();

            $this->login([
                'email' => $email,
                'user_name' => $user['username'],
                'userID' => $user['id'],
                'userProfile' => $user['profile_pic']
            ]);

            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->errors = 'Wrong email or password';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->errors = 'Wrong email or password';
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->errors = 'Email not verified';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->errors = 'Too many requests';
        }
        return false;
    }
    public function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'user_name' => $user['user_name'],
            'userID' => $user['userID'],
            'userProfile' => $user['userProfile']
        ];

        session_regenerate_id();
    }

    public function logout()
    {
        Session::destroy();
    }

    public function errors(): string
    {
        return $this->errors;
    }
}
