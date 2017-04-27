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
$posts = db_get_posts();

function find($post_id){
    global $posts;
    $post2 = $posts;
    while ($post2 = $post2->fetch_assoc()) {
        if($post2['post_id'] == $post_id) {
            return $post2;
        }
    }
    return null;
}

function is_post_author($user_id, $post_id) {
    $post = find($post_id);
    if($post && $user_id == $post['user_id']) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {

    $content = $_POST['content'];
    db_create_post($user_id, $content);
}

//TODO need post id
if (isset($_POST["delete"])) {
    $post_id = $_POST["id"];
    if(is_post_author($user_id, $post_id)) {
//        echo("<script>alert(" . $post_id . ")</script>");
        //db_delete_post($post_id);
    }
}

////TODO: need post content, post id  HELP?
//if (isset($_POST["edit"])) {
//
//    $post_id = $_GET['postid'];
//
//    db_update_post($post_id);
//}


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


        while ($post = $posts->fetch_assoc()) {
//            $link = urlencode($_SERVER["PHP_SELF"]) . "?deleteid=" . urlencode($post['post_id']);
//            $link = "?deleteid=" . urlencode($post['post_id']);
            $delete_button = ($user_name == $post['author']) ?

//                '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                '<form method="post" action="#">
                    <input type="hidden" name="id" value="' . htmlspecialchars($post['post_id']) . '" />
                    <div class="form-group">
                        <button name="delete" type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>' : "";


            echo
                '<div class="panel panel-default">' .
                '<div class="panel-heading">' . htmlspecialchars($post['author']) .  htmlspecialchars($post['post_id']) .'</div>' .
                '<div class="panel-body">' .
                htmlspecialchars($post['content']) . '<br />' .
                htmlspecialchars($post['date']) .
                $delete_button .
                '</div>' .
                '</div>';

        } ?>
    </div>
</div>
