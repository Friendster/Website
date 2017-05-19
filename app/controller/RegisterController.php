<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 19:42
 */
class RegisterController {
    private $model;

    public function __construct(RegisterModel $model) {
        $this->model = $model;
    }

    public function onRegister() {
        global $session;
        if (isset($_POST["register"]) && $_POST["token"] == $session->get(Properties::TOKEN)) {
            $this->model->setEmail($_POST["email"]);
            $this->model->setPassword($_POST["password"]);
            $this->model->setPasswordVerify($_POST["password_verify"]);

            $is_email_valid = $this->model->validateEmail();
            $is_password_valid = $this->model->validatePassword();
            $are_passwords_verified = $this->model->verifyPasswords();

            $is_recaptcha_valid = $this->model->validateRecaptcha($_POST["g-recaptcha-response"]);

            if ($is_email_valid && $is_password_valid && $are_passwords_verified && $is_recaptcha_valid) {
                $user_id = $this->model->registerUser();
                $profile = Database::getProfile($user_id);;
                $session->login($profile);
            }

        }
    }
}
