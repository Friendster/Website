<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 22-Apr-17
 * Time: 11:18
 */


$profile = db_get_profile($_SESSION['user_id']);
$img_name = empty($profile->profile_picture_name) ? "oOskDVlsS002iszDIcrWqdckY8aM8k.png" : $profile->profile_picture_name;
$iv = $_SESSION["iv"];
$encrypted_img_name = urlencode(encrypt($img_name, $iv));
$img_path = "?page=image&file=" . $encrypted_img_name;

include "profile_upload.php";

?>
<div class="container-fluid nopadding cover">


    <div class="col-md-3">
        <div class="panel panel-default profile">
            <div class="panel-body">
                <a href="#modal" data-toggle="modal">
                    <img src="<?php echo $img_path; ?>" alt="">
                </a>
            </div>
        </div>
    </div>

    <?php
    if (!empty($error_upload)) {
        echo
            '<div class="alert alert-dismissible alert-danger">' .
            '   <button type="button" class="close" data-dismiss="alert">&times;</button>' .
            '   <strong>Oh snap! </strong>' . htmlentities($error_upload) .
            '</div>';
    } else if (isset($_GET['success'])) {
        echo
            '<div class="alert alert-dismissible alert-success">' .
            '   <button type="button" class="close" data-dismiss="alert">&times;</button>' .
            '   <strong>Well done! </strong>' . htmlentities(urldecode($_GET['success'])) .
            '</div>';
    }


    ?>

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

                <form action='#'
                      method='post'
                      enctype='multipart/form-data'
                      class='form-horizontal'>

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
</div>
