<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/4/2017
 * Time: 19:15
 */
//
//include "model/user.php";

function connect_to_db() {
    $servername = "127.0.0.1";
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

// http://php.net/manual/en/mysqli-stmt.get-result.php
// http://php.net/manual/en/mysqli.prepare.php - see also solution for results to arrays here
function db_get_user($user) {
    $userObj = new stdClass();

    // Connect to db
    $conn = connect_to_db();

    // Define sql
    $sql = "SELECT pass, id FROM user WHERE email=?";

    // Prepare statemet
    if ($stmt = $conn->prepare($sql)) {

        // Bind user parameter
        $stmt->bind_param('s', $user);

        // Execute query
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($userObj->pass, $userObj->id);

        // Fetch value
        $stmt->fetch();
        $stmt->close();
    }


    $conn->close();

    return $userObj;
}

function db_create_post($user_id, $content) {
    // Connect to db
    $conn = connect_to_db();

    // Define sql
    $sql = "INSERT INTO `post` (`user_id`, `content`) VALUES (?,?)";

    // Prepare statemet
    if ($stmt = $conn->prepare($sql)) {

        // Bind user parameter
        $stmt->bind_param('is', $user_id, $content);

        // Execute query
        $stmt->execute();

        // Fetch value
        $stmt->fetch();

        $stmt->close();
    }

    $conn->close();

}


function db_get_posts() {
    // Connect to db
    $conn = connect_to_db();

    // Define sql
    $sql = "SELECT `post`.`id` AS `post_id`, `user_id`, `content`, `date`, `email` AS `author` FROM `post`, `user` WHERE `user_id`=`user`.`id`";

    // Get result
    $result = $conn->query($sql);

    // Close connection
    $conn->close();

    return $result;

}

//echo password_hash("1234", PASSWORD_BCRYPT, ['cost' => 9])."\n";
//echo password_verify("1234" , "\$2y$09\$JaMRjTBdfkVpxMqUdMCVcO/0yjWJkMdMRQVacVwKehem4D4dUMdb6")? "true" : "false";


