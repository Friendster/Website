<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 14:15
 */
class ImageManager {


    public static function serveImage($file) {
        global $session;

        $iv = $session->get(Session::IV);
        $file_name = urldecode(EncryptionManager::decrypt($file, $iv));
        $file_name = ImageManager::sanitizeImageName($file_name);
        $target_file = "../../uploads/" . $file_name;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        header("Content-type: " . finfo_file($finfo, $target_file));
        finfo_close($finfo);

        $handle = fopen($target_file, "r");
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detectedType = exif_imagetype($target_file);
        $error = !in_array($detectedType, $allowedTypes);
        if (!$error) {
            $contents = '';
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            return $contents;
        }

    }

    private static function sanitizeImageName($fileName) {
        $file = htmlspecialchars($fileName);
        $file = preg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file);

        // Remove any runs of periods
        $file = preg_replace("([\.]{2,})", '', $file);
        return $file;
    }

    public static function uploadImage($file, $file_name) {
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
}
