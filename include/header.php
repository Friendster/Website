<?php
session_start();

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




