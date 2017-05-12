<?php

session_start();
include "../include/crypt.php";

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$iv = $_SESSION["iv"];
$file_name = decrypt($_GET["file"], $iv);
$target_file = "../../uploads/" . $file_name;

header("Content-type: ".finfo_file($finfo, $target_file));
finfo_close($finfo);

$handle=fopen($target_file, "r");
while (!feof($handle)) {
    @$contents.= fread($handle, 8192);
}
echo $contents;

