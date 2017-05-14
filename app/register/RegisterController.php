<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 19:42
 */
class RegisterController {
    private $model;

    public function __construct($model) {
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

            if ($is_email_valid && $is_password_valid && $are_passwords_verified) {
                $user_id = $this->model->registerUser();
                $this->login($user_id);
            }

        }
    }

    private function login($user_id) {

        if (!empty($user_id)) {
            $profile = db_get_profile($user_id);
//            login($profile);


            //session_start();

            // TODO refactor session name -> email

            // TODO encapsulate session into a session object
            $_SESSION["name"] = $profile->email;
            $_SESSION["user_id"] = $profile->id;
            $_SESSION["profile_picture_name"] = $profile->profile_picture_name;

            // TODO add other profile details

            navigate_to();


        }



    }
}