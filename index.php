<?php

include "include/init.php";
include "include/header.php";

if (!isset($_SESSION["name"])) {
    include "app/login_page.php";
} else {

    include "include/navigation.php";

    include "app/profile_header.php";
    include "app/post_page.php";

}

include "include/footer.php";
?>
