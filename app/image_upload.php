<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 07-May-17
 * Time: 14:10
 */

function upload($file, $file_name) {
    $target_file = "../../uploads/" . $file_name;

    if (move_uploaded_file($file, $target_file)) {
        // If we successfully move file, then edit permissions
        $no_exec_mode = 0644;
        chmod($target_file, $no_exec_mode);
        return true;
    } else {
        return false;
    }
}
