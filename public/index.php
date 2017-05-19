<?php
include "../system/init.php";

if (is_page('image')) {
    include "../app/image.php";
} else {

    include "../system/header.php";
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

        if(isset($_GET['page'])) {
            // Generic page
            include('../app/' . $_GET['page'] . '.php');
        } else {

            // Include frontpage
            include "../system/navigation.php";
            include "../app/profile_header.php";
            include "../app/post_page.php";
        }

    }

    include "../system/footer.php";

}


function is_logged_in() {
    global $session;
    return $session->get(Properties::ID) != null;
}

function is_page($name) {
    return isset($_GET['page']) && $_GET['page'] == $name;
}



