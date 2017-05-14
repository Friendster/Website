<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 13:27
 */
class LoginModel {
    private $id;
    private $email;
    private $password;
    public $emailError;
    public $passwordError;
    public $recaptchaError;
    public $loginError;

    public function __construct(){
        $this->id = '';
        $this->email = '';
        $this->password = '';
        $this->emailError = '';
        $this->passwordError = '';
        $this->recaptchaError = '';
        $this->loginError = '';
    }

    public function validateEmail()
    {
        $is_valid = !empty($this->email);
        $this->emailError = $is_valid ? '' : 'is required';

        return $is_valid;
    }

    public function validatePassword()
    {
        $is_valid = !empty($this->password);
        $this->passwordError = $is_valid ? '' : 'is required';

        return $is_valid;
    }

    public function verifyLogin() {
        $db_user = db_get_user($this->email);
        $hashed_pw = $db_user->password;
        $this->id = $db_user->id;

        $is_valid = !empty($hashed_pw);
        $is_valid = $is_valid && password_verify($this->password, base64_decode($hashed_pw));

        if (!$is_valid) {
            $this->loginError = 'Username or password is wrong';
        }

        return $is_valid;

    }

    public function getProfile() {
        return db_get_profile($this->id);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = htmlspecialchars($email);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = htmlspecialchars($password);
    }




}