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

    $image_name = $_SESSION["name"] . "-profile";
    $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

    $target_file = "../uploads/" . $image_name . "." . $image_file_type;

    if($is_profile_valid) {
        // If everything is ok, try to upload file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $message_upload .= "The file " . basename($file["name"]) . " has been uploaded. ";

            // If upload was successful, update the db
            db_update_profile_picture($_SESSION["user_id"], $target_file);
        } else {
            $error_upload .=  "Sorry, there was an error uploading your file.";
            $is_profile_valid = false;
        }

    }
//    set_location_to_root();
}

function validate_profile($file) {
    global $error_upload, $message_upload;
    $is_valid = true;

    $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);
    $image_file_size = getimagesize($file["tmp_name"]);

    // Check if file is an image
    if ($image_file_size !== false) {
        $message_upload .= "File is an image - " . $image_file_size["mime"] . ". ";
        $is_valid = true;
    } else {
        $error_upload .= "File is not an image. ";
        $is_valid = false;
    }

    // Check file size
    if ($file["size"] > 500000) {
        $error_upload .=  "Sorry, your file is too large. ";
        $is_valid = false;
    }

    // Allow certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        $error_upload .=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $is_valid = false;
    }

    // Check if $uploadOk is set to false by an error
    if ($is_valid == false) {
        $error_upload .=  "Sorry, your file was not uploaded. ";
    }

    return $is_valid;
}