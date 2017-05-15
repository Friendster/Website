<?php
/**
 * This file should use the db, create the session, config,
 */

//include "db.php";

//$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
//$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');



include "app/Session.php";
$session = new Session();

$session->tryDestroySession();

$session->tryRegenerateSession();

include "crypt.php";
if ($session->get(Properties::TOKEN) == null) {
    $session->set(Properties::TOKEN, generate_name_from_iv());
}



include "config.php";
include "db.php";

include "googlerecaptcha.php";
include "app/image_upload.php";


function navigate_to($query = "")
{
    global $config;
    $root_location = ($config->host != "localhost") ? "/" : "index.php". $query;

    header("Location:" . $root_location);
}

//$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
//$configs = include($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');

include "util/ValidationHandler.php";
include "app/login/LoginController.php";
include "app/login/LoginModel.php";
include "app/login/LoginView.php";

include "app/register/RegisterController.php";
include "app/register/RegisterModel.php";
include "app/register/RegisterView.php";
