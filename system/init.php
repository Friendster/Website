<?php
/**
 * This file should use the db, create the session, config,
 */
include "../app/entities/User.php";
include "../app/entities/Post.php";

include "../app/entities/Session.php";
include "../system/SessionManager.php";



$session = new SessionManager();

$session->tryDestroySession();
$session->tryRegenerateSession();
include "EncryptionManager.php";
// Set static IV
if ($session->get(Session::IV) == null) {
    $session->set(Session::IV, EncryptionManager::generateIv());
}
if ($session->get(Session::TOKEN) == null) {
    $session->set(Session::TOKEN, EncryptionManager::generateNameFromIv());
}


include "../app/entities/Config.php";
include "Database.php";



function navigate($query = "")
{
    $root_location = (Config::$host != "localhost") ? "/" : "index.php". $query;
    header("Location:" . $root_location);
}

include "RecaptchaManager.php";
include "ValidationManager.php";
include "ImageManager.php";

include "../app/entities/Action.php";
include "../app/entities/Router.php";

include "../app/controller/AppController.php";
include "../app/model/AppModel.php";
include "../app/view/AppView.php";
