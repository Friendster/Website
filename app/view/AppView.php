<?php


class AppView {
    private $model;
    private $controller;

    public function __construct(AppController $controller, AppModel $model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function outputHeader() {
        return '<!DOCTYPE html>
            <html lang="en">
            <head>
            
                <!-- Required meta tags -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="detectify-verification" content="8bb11b03bc4934bd011683bb3796d5a0" />
    
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
                <link rel="stylesheet" href="' . $this->model->getStyle() . '" type="text/css">

            </head>
            <body>
                <div class="container-fluid nopadding">';
    }

    public function outputNavbar() {
        return '<nav class="navbar navbar-default nomargin">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Friendster</a>
                </div>
        
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav navbar-right">
                        <li><p class="navbar-text">Logged in as: ' . $this->model->getUser() .'</p></li>
                        <li><a href="?page=login">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>';
    }

    public function outputFooter() {
        return  '</div>

                <!-- Google reCAPTCHA -->
                <script src="https://www.google.com/recaptcha/api.js"></script>
                
                <!-- jQuery first, then Tether, then Bootstrap JS. -->
                <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
            </body>
            </html>';
    }
}