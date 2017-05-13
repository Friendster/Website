<?php
include "include/init.php";
if(isset($_GET['page']) && $_GET['page'] == 'image'){
    include('app/' . $_GET['page'] . '.php');
}else {

    include "include/header.php";

    if (!isset($_SESSION["name"])) {
        if (isset($_GET['page']) && $_GET['page'] == 'register') {
            include "app/register.php";
        } else {
            include "app/login_page.php";
        }

    } else if (isset($_GET['page'])) {
        include('app/' . $_GET['page'] . '.php');
    } else {

        // Include frontpage

        include "include/navigation.php";
        include "app/profile_header.php";
        include "app/post_page.php";
    }

    include "include/footer.php";

}





