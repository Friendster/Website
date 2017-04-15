<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/4/2017
 * Time: 19:15
 */

function connect_to_db() {
    $servername = "188.226.140.147";
    $username = "root";
    $password = "db#2IsAw3s0me";
    $db = "friendster";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->error) {
        die("DB connection failed. Error " . $conn->connect_errno . " " . $conn->connect_error);
    }
    return $conn;
}


//echo password_hash("1234", PASSWORD_BCRYPT, ['cost' => 9])."\n";
//echo password_verify("1234" , "\$2y$09\$JaMRjTBdfkVpxMqUdMCVcO/0yjWJkMdMRQVacVwKehem4D4dUMdb6")? "true" : "false";


