<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 13:27
 */
class LoginController {
    private $model;

    public function __construct($model){
        $this->model = $model;
    }

    public function onLogin() {
        if (isset($_POST["submit"])) {
            $this->model->setEmail($_POST["usr"]);
            $this->model->setPassword($_POST["pass"]);

            $is_user_valid = $this->model->validateEmail();
            $is_pass_valid = $this->model->validatePassword();
            $is_recaptcha_valid = true;
//            $is_recaptcha_valid = is_recapcha_valid($_POST["g-recaptcha-response"]);

//            if (!$is_recaptcha_valid) {
//                $recaptcha_error = "Please validate recapcha";
//            }

            // If user input is ok so far then QUERY db
            if ($is_user_valid && $is_pass_valid && $is_recaptcha_valid) {
                $is_correct_credentials = $this->model->verifyLogin();

                if($is_correct_credentials) {
                    $profile = $this->model->getProfile();
                    $this->login($profile);
                }
            }

        }
    }

    private function login($profile)
    {
        session_start();

        // TODO refactor session name -> email

        // TODO encapsulate session into a session object
        $_SESSION["name"] = $profile->email;
        $_SESSION["user_id"] = $profile->id;
        $_SESSION["profile_picture_name"] = $profile->profile_picture_name;

        // TODO add other profile details

        set_location_to_root();
    }

    public function onLogout()
    {
        session_start();
        // TODO why are we doing it like this?
        $_SESSION = array();
        session_destroy();

        set_location_to_root();
    }

}