<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/4/2017
 * Time: 19:15
 */

// TODO UPDATE TO PDO
$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');

function connect_to_db() {
    global $configs;

    $host = $configs->database_host;
    $username = $configs->username;
    $password = $configs->password;
    $db = $configs->database;

    // Create connection
    $conn = new mysqli($host, $username, $password, $db);

    // Check connection
    if ($conn->error) {
        die("DB connection failed. Error " . $conn->connect_errno . " " . $conn->connect_error);
    }
    return $conn;
}

function db_create_user($email, $hashed_pw) {
    //todo: error check if db is unavailable
    $conn = connect_to_db();
    $query = "INSERT INTO user (email, pass) VALUES(?, ?)";

    $stmt = $conn->stmt_init();


    if (!$stmt->prepare($query)) {
        print "Failed to prepare statement\n";
    } else {

        $stmt->bind_param('ss', $email, $hashed_pw);

        //execution on the information injection into the db
        $stmt->execute();

    }

    $stmt->close();
    $conn->close();
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
        $stmt->bind_result($userObj->password, $userObj->id);

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

function db_get_profile($user_id) {
    $profile_obj = new stdClass();
    // Connect to db
    $conn = connect_to_db();

    // Define sql
    $sql = "SELECT `name`, `description`, `profilePictureName`, `dateOfBirth` FROM `user` WHERE `id`=?";

    // Prepare statemet
    if ($stmt = $conn->prepare($sql)) {

        // Bind user parameter
        $stmt->bind_param('s', $user_id);

        // Execute query
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($profile_obj->name, $profile_obj->description, $profile_obj->profile_picture_name, $profile_obj->date_of_birth);

        // Fetch value
        $stmt->fetch();
        $stmt->close();
    }


    $conn->close();

    return $profile_obj;
}


function db_update_profile_picture($user_id, $profile_picture_name) {
    // Connect to db
    $conn = connect_to_db();

    // Define sql
    $sql = "UPDATE `user` SET `profilePictureName` = ? WHERE `user`.`id` = ?";

    // Prepare statemet
    if ($stmt = $conn->prepare($sql)) {

        // Bind user parameter
        $stmt->bind_param('si', $profile_picture_name, $user_id);

        // Execute query
        if($stmt->execute()) {
            echo "DB EXECUTED";
        } else {
            echo "DB ERR";
        }

        $stmt->close();
    }

    $conn->close();
}
