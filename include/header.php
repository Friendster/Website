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
    <a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/188.226.140.147"><img src="https://seal.beyondsecurity.com/verification-images/188.226.140.147/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>
</head>
<body>
<div class="container-fluid nopadding">




