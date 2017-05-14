<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 13:27
 */
class LoginView {
    private $model;
    private $controller;

    public function __construct($controller, $model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output() {
        $login_error = (!empty($this->model->loginError))
            ? '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong>' . $this->model->loginError . '</div>' : '';

        $email_error = (!empty($this->model->emailError)) ? $this->model->emailError : '';
        $password_error = (!empty($this->model->passwordError)) ? $this->model->passwordError : '';
        $recaptcha_error = (!empty($this->model->recaptchaError)) ? $this->model->recaptchaError : '';

        $template =
            '<div class="my-login-box panel panel-default">
                <div class="panel-body">
                    <form method="post" action="?page=login" autocomplete="off">
                        <legend>Enter Wonderland!</legend>' .

                        $login_error .
    
                        '<div class="form-group ' . (!empty($email_error) ? 'has-error' : '') . '">
                            <label class="control-label" for="email">Unicorn email ' . $email_error . '</label>
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
                                name="password" value="' . $this->model->getPassword() . '">
                        </div>
    
   
                        <div class="">
                            <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
                        </div>' .
                
                        $recaptcha_error .
                
                        '<div class="form-buttons">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                            <a class="btn btn-default" href="?page=register">Register?</a>
                        </div>
    
                    </form>
                </div>
            </div>'
                ;

        return $template;
    }

}