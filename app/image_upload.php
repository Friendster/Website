<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 07-May-17
 * Time: 14:10
 */

function upload($file, $file_name) {
    $target_file = "../uploads/" . $file_name;
    return move_uploaded_file($file, $target_file);
}
