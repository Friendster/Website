<?php
/**
 * This file should use the db, create the session, config,
 */

//include "db.php";

//$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
//$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');


session_start();
//Regenerate session every 5 minutes
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 300) {
    // session started more than 5 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}
//Destroy session if last activity was 10 minutes ago
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
    // last request was more than 10 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


include "config.php";
include "db.php";
include "crypt.php";
include "app/image_upload.php";


function set_location_to_root()
{
    global $config;
    $root_location = ($config->host != "localhost") ? "/" : "index.php";

    header("Location:" . $root_location);
}

//$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
//$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');


