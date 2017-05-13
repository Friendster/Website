<?php

session_start();
include "../include/crypt.php";

$iv = $_SESSION["iv"];
$file_name = urldecode(decrypt($_GET["file"], $iv));
$file_name = sanitize($file_name);
$target_file = "../../uploads/" . $file_name;

$finfo = finfo_open(FILEINFO_MIME_TYPE);
header("Content-type: " . finfo_file($finfo, $target_file));
finfo_close($finfo);

$handle = fopen($target_file, "r");
$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
$detectedType = exif_imagetype($target_file);
$error = !in_array($detectedType, $allowedTypes);
if (!$error) {
    while (!feof($handle)) {
        @$contents .= fread($handle, 8192);
    }
    echo $contents;
}


// TODO add comments
function sanitize($file_name) {
    $file = htmlspecialchars($file_name);
    $file = preg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file);

    // Remove any runs of periods
    $file = preg_replace("([\.]{2,})", '', $file);
    return $file;
}



