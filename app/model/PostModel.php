<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 14:40
 */
class PostModel {
    private $user_name;
    private $user_id;
    private $posts;
    private $iv;

    public function __construct() {
        global $session;

        $this->user_name = $session->get(Properties::EMAIL);
        $this->user_id = $session->get(Properties::ID);
        $this->iv = $session->get(Properties::IV);
        $this->posts = Database::getPosts();
    }

    function find($post_id) {
        foreach ($this->posts as $post) {
            if ($post['post_id'] == $post_id) {
                return $post;
            }
        }
        return null;
    }

    function is_post_author($user_id, $post_id) {
        $post = find($post_id);
        if ($post && $user_id == $post['user_id']) {
            return true;
        } else {
            return false;
        }
    }

}