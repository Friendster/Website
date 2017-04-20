<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_style()?>" type="text/css">

</head>
<body>
<div class="container-fluid">

<?php
session_start();

function get_style() {
	$ssl="";
    $customPath = ($_SERVER['SERVER_NAME'] == 'localhost')? ':8081/Friendster': '';
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
    	$ssl="s";	.

    $link = 'http'.$ssl.'://' . $_SERVER['SERVER_NAME'] . $customPath . '/css/mystyle.css';
    return $link;

}
?>


