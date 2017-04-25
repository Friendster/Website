<?php
//TODO: Should this be in the header or somewhere else? Preferably in a method and a file of its own, but that's problematic(See CSS)
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

$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');

function get_style() {
    global $configs;

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    $host = $_SERVER['SERVER_NAME'];
    $port = (!empty($configs->port)) ? ':' . $configs->port : '';
    $customPath = ($host == $configs->host) ? $configs->path : '';

    $link = $protocol . $host . $port . $customPath . '/css/mystyle.css';

    return $link;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
    <link rel="stylesheet" href=<?php echo get_style();?> type="text/css">

</head>
<body>
<div class="container-fluid nopadding">




