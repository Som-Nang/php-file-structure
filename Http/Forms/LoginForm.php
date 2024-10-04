<?php

namespace Http\Forms;

use Core\Validation;

class LoginForm{
    protected $errors = [];

    public function validation($email, $password):bool{
        if (!Validation::email($email)) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }
        if (!Validation::string($password, 7, 255)) {
            $this->errors['password'] = 'Please provide a valid password';
        }
        return empty($this->errors);
    }

    public function errors(){
        return $this->errors;
    }

    public function error($field, $message){
        $this->errors[$field] = $message;
    }
}
