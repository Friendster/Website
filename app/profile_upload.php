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

    $file_name = (empty($_SESSION["profile_picture_name"]))
        ? generate_name_from_iv() . $_SESSION["user_id"] . "." . $image_file_type
        : $_SESSION["profile_picture_name"];

    if ($is_profile_valid) {
        // If everything is ok, try to upload file
        if (upload($file["tmp_name"], $file_name)) {
            $message_upload .= "The file " . basename($file["name"]) . " has been uploaded. ";

            // If upload was successful, update the db
            db_update_profile_picture($_SESSION["user_id"], $file_name);

            set_location_to_root("?success=".urlencode($message_upload));
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