<?php


class ProfileView
{
    private $model;
    private $controller;

    public function __construct(ProfileController $controller, ProfileModel $model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output()
    {
        $message = !empty($this->model->error_upload)
            ? '<div class="alert alert-dismissible alert-danger">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>\
                           <strong>Oh snap! </strong>' . htmlentities($this->model->error_upload) . '
                        </div>'
            : isset($_GET['success'])
                ? '<div class="alert alert-dismissible alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Well done! </strong>' . htmlentities(urldecode($_GET['success'])) . '
                        </div>'
                : "";

        $template =
            '<div class="container-fluid nopadding cover">
                <div class="col-md-3">
                    <div class="panel panel-default profile">
                        <div class="panel-body">
                            <a href="#modal" data-toggle="modal">
                                <img src=' . $this->model->image_path . ' alt="">
                            </a>
                        </div>
                    </div>
                </div>
            
                ' . $message . '
            </div>
            
            <div id="modal" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Upload profile</h4>
                        </div>
            
            
                        <div class="modal-body">
                            <p>Select an image from your computer</p>
            
                            <form action=\'#\'
                                  method=\'post\'
                                  enctype=\'multipart/form-data\'
                                  class=\'form-horizontal\'>
            
                                <div class="form-group">
            
                                    <input type="file" name="profile" class="form-control" id="profile"/>
            
                                </div>
            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" name="upload_profile" class="btn btn-primary">Save</button>
                                </div>
                            </form>
            
                        </div>
            
            
                    </div>
                </div>
            </div>';

        return $template;
    }
}