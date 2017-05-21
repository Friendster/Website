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


        if (isset($_POST["upload_profile"])) {
            $file = $_FILES["profile"];
            $isUploaded = $this->model->tryUploadProfile($file);
            if ($isUploaded) {
                RouteManager::navigate();
            }
        }
        if (isset($_POST["notification_close"])) {
            $this->model->setSuccessUpload("");
        }
    }
}