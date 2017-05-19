<?php
/**
 * This file should use the db, create the session, config,
 */

include "../system/session/Properties.php";
include "../system/session/SessionManager.php";

$session = new SessionManager();

$session->tryDestroySession();

$session->tryRegenerateSession();

include "../util/crypt.php";
if ($session->get(Properties::TOKEN) == null) {
    $session->set(Properties::TOKEN, generate_name_from_iv());
}



include "../config.php";
include "../system/db.php";

include "../util/googlerecaptcha.php";
include "../app/image_upload.php";


function navigate_to($query = "")
{
    global $config;
    $root_location = ($config->host != "localhost") ? "/" : "index.php". $query;

    header("Location:" . $root_location);
}

//$customPath = (empty($_SERVER['HTTPS'])) ? '/Friendster' : '';
//$configs = system($_SERVER['DOCUMENT_ROOT'] . $customPath . '/config.php');

include "ValidationHandler.php";

include "../app/controller/LoginController.php";
include "../app/model/LoginModel.php";
include "../app/view/LoginView.php";

include "../app/controller/RegisterController.php";
include "../app/model/RegisterModel.php";
include "../app/view/RegisterView.php";
