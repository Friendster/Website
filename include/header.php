<?php


function get_style() {
    global $config;

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    $host = $config->host;
    $port = (!empty($config->port)) ? ':' . $config->port : '';
    $customPath = ($host === 'localhost') ? $config->path : '';

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




