<?php

class ProfileModel
{
    public $message_upload;
    public $error_upload;
    public $image_path;

    public function __construct(){
        $this->message_upload = '';
        $this->error_upload = '';
        $this->image_path = '';
    }
}