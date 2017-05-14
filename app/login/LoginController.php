<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 13:27
 */
class LoginController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function onLogin() {
        global $session;

        if (isset($_POST["login"]) && $_POST["token"] == $session->get(Properties::TOKEN)) {
            $this->model->setEmail($_POST["email"]);
            $this->model->setPassword($_POST["password"]);

            $is_user_valid = $this->model->validateEmail();
            $is_pass_valid = $this->model->validatePassword();
            $is_recaptcha_valid = $this->model->validateRecaptcha($_POST["g-recaptcha-response"]);

            // If user input is ok so far then QUERY db
            if ($is_user_valid && $is_pass_valid && $is_recaptcha_valid) {
                $is_correct_credentials = $this->model->verifyLogin();

                if ($is_correct_credentials) {
                    $profile = $this->model->getProfile();
                    $session->login($profile);
                }
            }

        }
    }

}