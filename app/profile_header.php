<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 22-Apr-17
 * Time: 11:18
 */

$img = "uploads/" . $_SESSION['name'] . '-profile.png';

?>
<div class="container-fluid nopadding cover">


    <div class="col-md-3">
        <div class="panel panel-default profile">
            <div class="panel-body">
                <a href="#modal" data-toggle="modal"><img src="<?php echo $img;?>" alt=""></a>
            </div>
        </div>
    </div>

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

                <form action='app/profile_upload.php' class='form-horizontal' method='post'
                      enctype='multipart/form-data'>
                    <div class="form-group">

                        <input type="file" name='fileToUpload' class="form-control" id="fileToUpload"
                               placeholder="Email"/>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>


        </div>
    </div>
</div>
