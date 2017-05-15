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
        $this->emailError = ValidationHandler::validateEmail($this->email);
        return ValidationHandler::isValid($this->emailError);
    }

    public function validatePassword() {
        $this->passwordError = ValidationHandler::validatePassword($this->password);
        return ValidationHandler::isValid($this->passwordError);
    }

    public function verifyPasswords() {

        $this->passwordVerifyError = ValidationHandler::validateRequired($this->passwordVerify);

        // Checks if the two user password input match
        if(ValidationHandler::isValid($this->passwordVerifyError)
            && $this->password !== $this->passwordVerify) {
            $this->passwordVerifyError = " must match password";
        }

        return ValidationHandler::isValid($this->passwordVerifyError);
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