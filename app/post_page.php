<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 19-Apr-17
 * Time: 17:50
 */

//include "include/db.php";


$user_name = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

if (isset($_POST['submit'])) {

    $content = $_POST['content'];
    db_create_post($user_id, $content);
}
//TODO need post id and userid of the post
if (isset($_POST["delete"])) {

    $post_id = $_GET['delete'];
    db_delete_post($post_id);
}
//TODO: need post content, post id and user id of the person who made the post. HELP?
if (isset($_POST["edit"])) {

    $post_id = $_GET['edit'];

    db_update_post($post_id);
}


?>
<div class="container-fluid">

    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo htmlspecialchars($user_name) ?></div>
            <div class="panel-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                    <div class="form-group">
                    <textarea placeholder="Add a new post" name="content" class="form-control" rows="3"
                              id="textArea"></textarea>
                    </div>

                    <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>

        <?php

        $posts = db_get_posts();
        while ($post = $posts->fetch_assoc()) {
            $delete_button = '<div class="form-group">' .
                '<button name="delete" type="delete" postid='.$post['post_id'].' class="btn btn">Delete</button>' .
                '</div>';
            $edit_button = '<div class="form-group">' .
                '<button name="edit" type="edit" postid='.$post['post_id'].' class="btn btn">Edit</button>' .
                '</div>';
//    echo
//    $post['post_id'] . " " .
//    $post['user_id'] . " " .
//    $post['content'] . " " .
//    $post['author'] . " " .
//    $post['date'];


            echo
                '<div class="panel panel-default">' .
                '<div class="panel-heading">' . htmlspecialchars($post['author']) . '</div>' .
                '<div class="panel-body">' .
                htmlspecialchars($post['content']) . '<br />' .
                htmlspecialchars($post['date']) .
                '</div>' .
                ($delete_button) .

                '</div>';

        } ?>
    </div>
</div>
