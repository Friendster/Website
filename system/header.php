<?php


function get_style() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    $host = Config::$host;
    $port = (!empty(Config::$port)) ? ':' . Config::$port : '';
    $customPath = ($host === 'localhost') ? Config::$path : '';

    $link = $protocol . $host . $port . $customPath . '/public/assets/css/mystyle.css';

    return $link;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="detectify-verification"
          content="8bb11b03bc4934bd011683bb3796d5a0" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
    <link rel="stylesheet" href=<?php echo get_style();?> type="text/css">

</head>
<body>
<div class="container-fluid nopadding">




