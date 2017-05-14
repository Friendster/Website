<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 19:46
 */
class RegisterModel {
    private $email;
    private $password;
    private $passwordVerify;

    private $emailError;
    private $passwordError;
    private $passwordVerifyError;

    private $recaptchaError;

    public function __construct() {
        $this->email = '';
        $this->password = '';
        $this->passwordVerify = '';
        $this->emailError = '';
        $this->passwordError = '';
        $this->passwordVerifyError = '';
        $this->recaptchaError = '';
    }

    public function registerUser() {
        $options = [
            'cost' => 11
        ];
        $hashed_pw = base64_encode(password_hash($this->password, PASSWORD_BCRYPT, $options));
        db_create_user($this->email, $hashed_pw);
        $user_id = db_get_user($this->email)->id;
        return $user_id;
    }

    public function validateEmail() {

        if (empty($this->email)) {
            $this->emailError = "is required";
        } // Checks to see if user input is a valid email address
        elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->emailError = "is NOT valid!";
        } // Check if user exists
        elseif (!empty($user = db_get_user($this->email)->id)) {
            $this->emailError = "has been registered";
        }
        return empty($this->emailError);
    }

    public function validatePassword() {

        // Validate not empty
        if (empty($this->password)) {
            $this->passwordError = "is required";
        } // TODO add comments
        elseif (strlen($this->password) < '8') {
            $this->passwordError = "must contain at least 8 characters!";
        } elseif (!preg_match("#[0-9]+#", $this->password)) {
            $this->passwordError = "must contain at least 1 number!";
        } elseif (!preg_match("#[A-Z]+#", $this->password)) {
            $this->passwordError = "must contain at least 1 capital letter!";
        } elseif (!preg_match("#[a-z]+#", $this->password)) {
            $this->passwordError = "must contain at least 1 lowercase letter!";
        }

        // Is valid if there is no error
        return empty($this->passwordError);
    }

    public function verifyPasswords() {

        // Validate not empty
        if (empty($this->passwordVerify)) {
            $this->passwordVerifyError = "is required";
        } // Checks if the two user password input match
        elseif ($this->password !== $this->passwordVerify) {
            $this->passwordVerifyError = " must match password";
        }

        return empty($this->passwordVerifyError);
    }

    public function validateRecaptcha($value)
    {
        $is_valid = is_recapcha_valid($value);
        $this->recaptchaError = $is_valid ? '' : 'Please validate recapcha';

        return $is_valid;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = htmlentities($email);
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = htmlentities($password);
    }

    /**
     * @return string
     */
    public function getPasswordVerify() {
        return $this->passwordVerify;
    }

    /**
     * @param string $passwordVerify
     */
    public function setPasswordVerify($passwordVerify) {
        $this->passwordVerify = htmlentities($passwordVerify);
    }

    /**
     * @return string
     */
    public function getEmailError() {
        return $this->emailError;
    }

    /**
     * @param string $emailError
     */
    public function setEmailError($emailError) {
        $this->emailError = htmlentities($emailError);
    }

    /**
     * @return string
     */
    public function getPasswordError() {
        return $this->passwordError;
    }

    /**
     * @param string $passwordError
     */
    public function setPasswordError($passwordError) {
        $this->passwordError = htmlentities($passwordError);
    }

    /**
     * @return string
     */
    public function getPasswordVerifyError() {
        return $this->passwordVerifyError;
    }

    /**
     * @param string $passwordVerifyError
     */
    public function setPasswordVerifyError($passwordVerifyError) {
        $this->passwordVerifyError = htmlentities($passwordVerifyError);
    }

    /**
     * @return string
     */
    public function getRecaptchaError() {
        return $this->recaptchaError;
    }

    /**
     * @param string $recaptchaError
     */
    public function setRecaptchaError($recaptchaError) {
        $this->recaptchaError = htmlentities($recaptchaError);
    }


}