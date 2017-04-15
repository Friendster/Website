<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/3/2017
 * Time: 20:35
 */

include "include/header.php";


if (!isset($_SESSION["name"])) {
    //header("Location: app/login.php");
    echo "<nav><a class=\"btn btn-primary\" href=\"app/login.php\">Login</a> " .
        "<a class=\"btn btn-secondary\" href=\"app/register.php\">Register</a></nav>";
} else {

    echo "You are now logged in as: " . $_SESSION["name"];
    echo "<nav><a class=\"btn btn-primary\" href=\"app/logout.php\">Logout</a></nav>";

}


include "include/footer.php";
?>
