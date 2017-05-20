<?php
/**
 * This file should use the db, create the session, config,
 */
include "../app/entities/User.php";
include "../app/entities/Post.php";

include "../system/session/Properties.php";
include "../system/session/SessionManager.php";



$session = new SessionManager();

$session->tryDestroySession();
$session->tryRegenerateSession();
include "EncryptionManager.php";
// Set static IV
if ($session->get(Properties::IV) == null) {
    $session->set(Properties::IV, EncryptionManager::generateIv());
}
if ($session->get(Properties::TOKEN) == null) {
    $session->set(Properties::TOKEN, EncryptionManager::generateNameFromIv());
}


include "Config.php";
include "Database.php";



function navigate_to($query = "")
{
    $root_location = (Config::$host != "localhost") ? "/" : "index.php". $query;
    header("Location:" . $root_location);
}

include "RecaptchaManager.php";
include "ValidationManager.php";
include "ImageManager.php";


include "../app/controller/AppController.php";
include "../app/model/AppModel.php";
include "../app/view/AppView.php";

include "../app/controller/LoginController.php";
include "../app/model/LoginModel.php";
include "../app/view/LoginView.php";

include "../app/controller/RegisterController.php";
include "../app/model/RegisterModel.php";
include "../app/view/RegisterView.php";

include "../app/controller/ProfileController.php";
include "../app/model/ProfileModel.php";
include "../app/view/ProfileView.php";

include "../app/controller/PostController.php";
include "../app/model/PostModel.php";
include "../app/view/PostView.php";