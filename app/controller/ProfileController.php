<?php

class ProfileController
{
    private $model;

    public function __construct(ProfileModel $model)
    {
        $this->model = $model;
    }

    public function onProfile()
    {
        $this->set_image_path();
        $this->try_upload_profile();
    }

    private function set_image_path()
    {
        global $session;

        $profile = Database::getProfile($session->get(Properties::ID));
        $img_name = empty($profile->profile_picture_name) ? "oOskDVlsS002iszDIcrWqdckY8aM8k.png" : $profile->profile_picture_name;
        $iv = $session->get(Properties::IV);
        $encrypted_img_name = urlencode(EncryptionManager::encrypt($img_name, $iv));

        $this->model->image_path = "?page=image&file=" . $encrypted_img_name;
    }

    private function try_upload_profile()
    {
        global $session;

        if (isset($_POST["upload_profile"])) {
            $file = $_FILES["profile"];

            $is_profile_valid = $this->validate_profile($file);

            $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

            $file_name = ($session->get(Properties::PROFILE_PICTIRE_NAME) == null)
                ? EncryptionManager::generateNameFromIv() . $session->get(Properties::ID) . "." . $image_file_type
                : $session->get(Properties::PROFILE_PICTIRE_NAME);

            if ($is_profile_valid) {
                // If everything is ok, try to upload file
                if (upload($file["tmp_name"], $file_name)) {
                    $this->model->message_upload .= "The file " . basename($file["name"]) . " has been uploaded. ";

                    // If upload was successful, update the db
                    Database::updateProfilePicture($session->get(Properties::ID), $file_name);

                    navigate_to("?success=" . urlencode($this->model->message_upload));
                } else {
                    $this->model->error_upload .= "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    private function validate_profile($file)
    {
        $image_file_type = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

        if (empty($file["tmp_name"])) {
            $this->model->error_upload .= "File name cannot be empty. ";
            $is_valid = false;
        } else {
            // Check if file is an image
            $image_file_size = getimagesize($file["tmp_name"]);
            if ($image_file_size !== false) {
                $is_valid = true;
            } else {
                $this->model->error_upload .= "File is not an image. ";
                $is_valid = false;
            }
        }

        // Check file size
        if ($is_valid && $file["size"] > 500000) {
            $this->model->error_upload .= "Sorry, your file is too large. ";
            $is_valid = false;
        }

        // Allow certain file formats
        if ($is_valid && $image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
            $this->model->error_upload .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            $is_valid = false;
        }

        return $is_valid;
    }
}