<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 22-Apr-17
 * Time: 15:44
 */

$message_upload = "";
$error_upload = "";

if (isset($_POST["upload_profile"])) {
    $file = $_FILES["profile"];

    $is_profile_valid = validate_profile($file);

    $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

    $file_name = ($session->get(Properties::PROFILE_PICTIRE_NAME) == null)
        ? EncryptionManager::generateNameFromIv() . $session->get(Properties::ID) . "." . $image_file_type
        : $session->get(Properties::PROFILE_PICTIRE_NAME);

    if ($is_profile_valid) {
        // If everything is ok, try to upload file
        if (ImageManager::uploadImage($file["tmp_name"], $file_name)) {
            $message_upload .= "The file " . basename($file["name"]) . " has been uploaded. ";

            // If upload was successful, update the db
            Database::updateProfilePicture($session->get(Properties::ID), $file_name);

            navigate_to("?success=".urlencode($message_upload));
        } else {
            $error_upload .= "Sorry, there was an error uploading your file.";
            $is_profile_valid = false;
        }

    }
}

function validate_profile($file)
{
    global $error_upload, $message_upload;


    $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

    if (empty($file["tmp_name"])) {
        $error_upload .= "File name cannot be empty. ";
        $is_valid = false;
    } else {
        // Check if file is an image
        $image_file_size = getimagesize($file["tmp_name"]);
        if ($image_file_size !== false) {
            $is_valid = true;
        } else {
            $error_upload .= "File is not an image. ";
            $is_valid = false;
        }
    }

    // Check file size
    if ($is_valid && $file["size"] > 500000) {
        $error_upload .= "Sorry, your file is too large. ";
        $is_valid = false;
    }

    // Allow certain file formats
    if ($is_valid && $image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        $error_upload .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $is_valid = false;
    }

    return $is_valid;
}