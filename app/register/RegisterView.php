<?php

class RegisterView {
    private $model;
    private $controller;

    public function __construct($controller, $model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output() {
        global $session;
        $email_error = $this->model->getEmailError();;
        $password_error = $this->model->getPasswordError();
        $password_verify_error = $this->model->getPasswordVerifyError();
        $recaptcha_error = (!empty($this->model->recaptchaError)) ? '<p class="text-danger">' . $this->model->recaptchaError . '</p>' : '';

        $template =
            '<div class="my-login-box panel panel-default" xmlns="http://www.w3.org/1999/html">
                <div class="panel-body">
                    <form method="post" action="?page=register" autocomplete="off">
                        <legend>Register for Friendster!</legend>

                        <div class="form-group ' . (!empty($email_error) ? 'has-error' : '') . '">
                            <label class="control-label" for="email">Email ' . $email_error . '</label>
                            <input type="text"
                                class="form-control ' . (!empty($email_error) ? 'form-control-danger' : '') . '" 
                                id="email"
                                name="email" value="' .
                            $this->model->getEmail() . '">
                        </div>
                    
                        <div class="form-group ' . (!empty($password_error) ? 'has-error' : '') . '">
                            <label class="control-label" for="password">Secret Magical Password ' . $password_error . '</label>
                            <input type="password"
                                 class="form-control ' . (!empty($password_error) ? 'form-control-danger' : '') . '" 
                                id="password"
                                name="password" value="' .
                            $this->model->getPassword() . '">
                        </div>
                        
                        <div class="form-group ' . (!empty($password_verify_error) ? 'has-error' : '') . '">
                            <label class="control-label" for="password">Verify Magical Password ' . $password_verify_error . '</label>
                            <input type="password"
                                 class="form-control ' . (!empty($password_verify_error) ? 'form-control-danger' : '') . '" 
                                id="password_verify"
                                name="password_verify" value="' .
                            $this->model->getPasswordVerify() . '">
                        </div>
                        
                        <div class="' . (!empty($recaptcha_error) ? 'recapcha-error' : '') . '">' .
                            $recaptcha_error .
                            '<div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
                        </div>
                        
                        <input type="hidden" name="token" value="' . $session->get(Properties::TOKEN) . '">
                        
                        <div class="form-buttons">
                            <button type="submit" name="register" class="btn btn-primary">Register</button>
                            <a class="btn btn-default" href="?page=login">Login</a>
                        </div>
    
                    </form>
                </div>
            </div>';

        return $template;
    }
}