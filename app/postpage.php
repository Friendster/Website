<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 19-Apr-17
 * Time: 17:50
 */

include "include/db.php";


$user_name = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

if(isset($_POST['submit'])) {

    $content = $_POST['content'];
    db_create_post($user_id, $content);
}

?>


<div class="panel panel-default">
    <div class="panel-heading"><?php echo $user_name ?></div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
            <fieldset>

                <div class="form-group">
                    <div class="col-lg-10">
                        <textarea placeholder="Add a new post" name="content" class="form-control" rows="3" id="textArea"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button name="submit" type="submit" class="btn btn-primary">Post</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">Author</div>
    <div class="panel-body">
        Panel content
    </div>
</div>