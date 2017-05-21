<?php
/**
 * This file should use the db, create the session, config,
 */
include "../app/entities/User.php";
include "../app/entities/Post.php";
include "../app/entities/Session.php";
include "../app/entities/Config.php";
include "../app/entities/Action.php";
include "../app/entities/Router.php";

include "SessionManager.php";
include "RouteManager.php";
include "EncryptionManager.php";
include "RecaptchaManager.php";
include "ValidationManager.php";
include "ImageManager.php";
include "Database.php";

include "../app/controller/AppController.php";
include "../app/model/AppModel.php";
include "../app/view/AppView.php";

$session = new SessionManager();

$session->tryDestroySession();
$session->tryRegenerateSession();

// Set static IV
if ($session->get(Session::IV) == null) {
    $session->set(Session::IV, EncryptionManager::generateIv());
}
if ($session->get(Session::TOKEN) == null) {
    $session->set(Session::TOKEN, EncryptionManager::generateNameFromIv());
}






