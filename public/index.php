<?php
include "../app/entities/User.php";
include "../app/entities/Post.php";
include "../app/entities/Session.php";
include "../app/entities/Config.php";
include "../app/entities/Action.php";
include "../app/entities/Router.php";

include "../system/SessionManager.php";
include "../system/RouteManager.php";
include "../system/EncryptionManager.php";
include "../system/RecaptchaManager.php";
include "../system/ValidationManager.php";
include "../system/ImageManager.php";
include "../system/Database.php";

include "../app/controller/AppController.php";
include "../app/model/AppModel.php";
include "../app/view/AppView.php";

$session = new SessionManager();


if (is_page('image')) {
    echo ImageManager::serveImage($_GET["file"]);
} else {

    $app_model = new AppModel();
    $app_controller = new AppController($app_model);
    $app_view = new AppView($app_controller, $app_model);

    echo $app_view->outputHeader();
    
    if (is_page('register') && !$session->isLoggedIn()) {

        mvc(Router::$register, Action::$onRegister);

    } else if (is_page('login') || !$session->isLoggedIn()) {
        // Login page
        if ($session->isLoggedIn()) {
            mvc(Router::$login, Action::$onLogout);
        } else {
            mvc(Router::$login, Action::$onLogin);
        }

    } else if ($session->isLoggedIn()) {

        // Include frontpage
        echo $app_view->outputNavbar();

        mvc(Router::$profile, Action::$onProfile);
        mvc(Router::$post, get_action());
    }

    echo $app_view->outputFooter();
    Database::closeConnection();

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
