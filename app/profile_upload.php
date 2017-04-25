<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 22-Apr-17
 * Time: 15:44
 */


include "../include/db.php";

session_start();

$image_name = $_SESSION["name"] . "-profile";
$image_file_type = pathinfo(basename($_FILES["profile"]["name"]), PATHINFO_EXTENSION);
$target_dir = "../uploads/";
$target_file = $target_dir . $image_name . "." . $image_file_type;

$upload_ok = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profile"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }
}

// Check file size
if ($_FILES["profile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $upload_ok = 0;
}
// Allow certain file formats
if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg"
    && $image_file_type != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $upload_ok = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($upload_ok == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["profile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Saving to db
$db_profile = "uploads/" . $image_name . "." . $image_file_type;
db_update_profile_picture($_SESSION["user_id"], $db_profile);

header("Location: ../index.php");

