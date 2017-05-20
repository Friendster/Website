<?php
include "../system/init.php";

$app_model = new AppModel();
$app_controller = new AppController($app_model);
$app_view = new AppView($app_controller, $app_model);

if (is_page('image')) {
    echo ImageManager::serveImage($_GET["file"]);
} else {

    echo $app_view->outputHeader();
    if (is_page('register') && !is_logged_in()) {

        // Register page
//        system "app/register.php";

        $register_model = new RegisterModel();
        $register_controller = new RegisterController($register_model);
        $register_controller->onRegister();

        $register_view = new RegisterView($register_controller, $register_model);

        echo $register_view->output();


    } else if (is_page('login') || !is_logged_in()) {
        // Login page

        $login_model = new LoginModel();

        $login_controller = new LoginController($login_model);

        $login_view = new LoginView($login_controller, $login_model);

        if (is_logged_in()) {
            $session->logout();
        } else {
            $login_controller->onLogin();
        }

        echo $login_view->output();

    } else if (is_logged_in()) {

        if (isset($_GET['page'])) {
            // Generic page
            include('../app/' . $_GET['page'] . '.php');
        } else {


            // Include frontpage
            include "../system/navigation.php";



            $profile_model = new ProfileModel();
            $profile_controller = new ProfileController($profile_model);
            $profile_controller->onProfile();

            $profile_view = new ProfileView($profile_controller, $profile_model);

            echo $profile_view->output();


            $post_model = new PostModel();
            $post_controller = new PostController($post_model);
            $post_controller->onCreate();
            $post_controller->onEdit();
            $post_controller->onDelete();
            $post_view = new PostView($post_controller, $post_model);
            echo $post_view->output();
        }

    }

    echo $app_view->outputFooter();
    Database::closeConnection();

}


function is_logged_in()
{
    global $session;
    return $session->get(Properties::ID) != null;
}

function is_page($name)
{
    return isset($_GET['page']) && $_GET['page'] == $name;
}



