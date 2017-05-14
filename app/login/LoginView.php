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
//        $error_message = '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong>' . $login_error . '</div>';

        $template =
            '<div class="my-login-box panel panel-default">
                <div class="panel-body">

                <form method="post" action="?page=login" autocomplete="off">
                    <legend>Enter Wonderland!</legend>'.

            // TODO add error message here
    
                    '<div class="form-group">
                        <label class="control-label" for="usr">Unicorn email</label>
                        <input type="text"
                               class="form-control"
                               id="usr"
                               name="usr" value="' . $this->model->getEmail() . '">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pass">Secret Magical Password</label>
                        <input type="password"
                               class="form-control"
                               id="pass"
                               name="pass" value="' . $this->model->getPassword() . '">
                    </div>
    
    
                    <div class="">
                        <div class="g-recaptcha" data-sitekey="6LcpFBoUAAAAAOCkYXYqvLNlnrFzXMn3DrSDdHzD"></div>
                    </div>
    
                    <div class="form-buttons">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-default" href="?page=register">Register?</a>
                    </div>
    
                </form>
            </div>
            </div>'
                ;

        return $template;
    }

}