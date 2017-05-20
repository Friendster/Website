<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 14-May-17
 * Time: 13:27
 */
class PostController {
    private $model;

    public function __construct(PostModel $model) {
        $this->model = $model;
    }

    public function onEdit() {
        //TODO: need post content, post id  HELP?
        if (isset($_POST["edit"])) {

            $post_id = EncryptionManager::decrypt($_POST["id"], $iv);
            $content = $_POST["edit-content"];
            if (is_post_author($user_id, $post_id)) {
                Database::updatePost($post_id, $content);
                navigate_to();
            }
        }
    }

    public function onDelete() {
        if (isset($_POST["delete"])) {
            $post_id = EncryptionManager::decrypt($_POST["id"], $iv);

            if (is_post_author($user_id, $post_id)) {
                Database::deletePost($post_id);
                navigate_to();

            }
        }
    }

    public function onCreate() {
        if (isset($_POST['submit'])) {

            $content = $_POST['content'];
            Database::createPost($user_id, $content);
            navigate_to();

        }
    }
}