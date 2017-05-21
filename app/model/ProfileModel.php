<?php

class ProfileModel
{

    private $image_path;

    private $error_upload;

    public function __construct()
    {
        $this->error_upload = '';
        $this->setImagePath();
    }


    public function tryUploadProfile($file)
    {
        global $session;


        $is_profile_valid = $this->validateProfile($file);

        $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

        $file_name = ($session->get(Session::PROFILE_PICTIRE_NAME) == null)
            ? EncryptionManager::generateNameFromIv() . $session->get(Session::ID) . "." . $image_file_type
            : $session->get(Session::PROFILE_PICTIRE_NAME);


        if ($is_profile_valid) {
            // If everything is ok, try to upload file
            if (ImageManager::uploadImage($file["tmp_name"], $file_name)) {
                $this->setSuccessUpload( "The file " . basename($file["name"]) . " has been uploaded. ");

                // If upload was successful, update the db
                Database::updateProfilePicture($session->get(Session::ID), $file_name);
            } else {
                $this->setErrorUpload("Sorry, there was an error uploading your file.");
                $is_profile_valid = false;
            }
        }
        return $is_profile_valid;
    }

    private function validateProfile($file)
    {
        $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

        if (empty($file["tmp_name"])) {
            $this->setErrorUpload("File name cannot be empty. ");
            $is_valid = false;
        } else {
            // Check if file is an image
            $image_file_size = getimagesize($file["tmp_name"]);
            if ($image_file_size !== false) {
                $is_valid = true;
            } else {
                $this->setErrorUpload("File is not an image. ");
                $is_valid = false;
            }
        }

        // Check file size
        if ($is_valid && $file["size"] > 500000) {
            $this->setErrorUpload("Sorry, your file is too large. ");
            $is_valid = false;
        }

        // Allow certain file formats
        if ($is_valid && $image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
            $this->setErrorUpload("Sorry, only JPG, JPEG, PNG & GIF files are allowed. ");
            $is_valid = false;
        }

        return $is_valid;
    }


    public function getImagePath(): string
    {
        return $this->image_path;
    }

    public function setImagePath()
    {
        global $session;

        $profile = Database::getProfile($session->get(Session::ID));
        $img_name = empty($profile->profile_picture_name) ? "oOskDVlsS002iszDIcrWqdckY8aM8k.png" : $profile->profile_picture_name;
        $iv = $session->get(Session::IV);
        $encrypted_img_name = urlencode(EncryptionManager::encrypt($img_name, $iv));

        $this->image_path = "?page=image&file=" . $encrypted_img_name;
    }


    public function getSuccessUpload(): string
    {
        global $session;
        return htmlentities($session->get(Session::NOTIFICATION));
    }

    public function setSuccessUpload(string $success_upload)
    {
        global $session;
        $session->set(Session::NOTIFICATION, $success_upload);
    }


    public function getErrorUpload(): string
    {
        return htmlentities($this->error_upload);
    }

    public function setErrorUpload(string $error_upload)
    {
        $this->error_upload = $error_upload;
    }
}