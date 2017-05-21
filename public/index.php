<?php
include "../system/init.php";

if (is_page('image')) {
    echo ImageManager::serveImage($_GET["file"]);
} else {

    $app_model = new AppModel();
    $app_controller = new AppController($app_model);
    $app_view = new AppView($app_controller, $app_model);

    echo $app_view->outputHeader();

    if (is_page('register') && !is_logged_in()) {

        mvc(Router::$register, Action::$onRegister);

    } else if (is_page('login') || !is_logged_in()) {
        // Login page
        if (is_logged_in()) {
            mvc(Router::$login, Action::$onLogout);
        } else {
            mvc(Router::$login, Action::$onLogin);
        }

    } else if (is_logged_in()) {

        // Include frontpage
        echo $app_view->outputNavbar();

        mvc(Router::$profile, Action::$onProfile);
        mvc(Router::$post, get_action());
    }

    echo $app_view->outputFooter();
    Database::closeConnection();

}


function is_logged_in() {
    global $session;
    return $session->get(Session::ID) != null;
}

function mvc($feature, $action) {
    $model = $feature . 'Model';
    $view = $feature . 'View';
    $controller = $feature . 'Controller';

    include "../app/model/$model.php";
    include "../app/controller/$controller.php";
    include "../app/view/$view.php";

    $m = new $model();
    $c = new $controller($m);
    $v = new $view($c, $m);

    if (!empty($action)) {
        $method = 'on' . $action;
        $c->$method();
    }

    echo $v->output();
}

function is_page($name) {
    return isset($_GET['page']) && strtolower($_GET['page']) == strtolower($name);
}

function get_action() {
    $class = new ReflectionClass('Action');
    $staticProperties = $class->getStaticProperties();

    foreach ($staticProperties as $propertyName => $value) {
        $action = strtolower($value);
        if (isset($_POST[$action])) {
            return $value;
        }
    }
}
