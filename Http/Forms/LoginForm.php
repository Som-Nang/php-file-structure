<?php

namespace Http\Forms;

use Core\Validation;
use Core\ValidationException;

class LoginForm{
    public $attributes;
    protected $errors = [];

    public function __construct(array $attributes){
        $this->attributes = $attributes;
        if (!Validation::email($attributes['email'])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if (!Validation::string($attributes['password'], 7, 100)) {
            $this->errors['password'] = 'Please provide a valid password';
        }
    }

    /**
     * @throws ValidationException
     */
    public static function validate($attributes){

        $instance = new static($attributes);

      return $instance->failed() ? $instance->throw() : $instance;
     }

    public function throw(){
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed(){
        return count($this->errors);
    }

    public function errors(){
        return $this->errors;
    }

    public function error($field, $message){
        $this->errors[$field] = $message;

        return $this;
    }
}
