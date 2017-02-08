<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/4/2017
 * Time: 19:15
 */

function connect_to_db() {
    $servername = "192.185.128.39";
    $username = "adrielsi_cris";
    $password = "z#@S6Rs5hyw.";
    $db = "adrielsi_crisdb";
    $port = "3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


//
//echo password_hash("1234", PASSWORD_BCRYPT, ['cost' => 9])."\n";
//echo password_verify("1234" , "\$2y$09\$JaMRjTBdfkVpxMqUdMCVcO/0yjWJkMdMRQVacVwKehem4D4dUMdb6")? "true" : "false";