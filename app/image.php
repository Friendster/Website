<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 07-May-17
 * Time: 13:35
 */

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$target_file = "../../uploads/" . $_GET["file"];

header("Content-type: ".finfo_file($finfo, $target_file));
finfo_close($finfo);

$handle=fopen($target_file, "r");
while (!feof($handle)) {
    @$contents.= fread($handle, 8192);
}
echo $contents;

