<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 14:40
 */
class PostModel {
    private $userName;
    private $userId;
    private $posts;
    private $iv;

    public function __construct() {
        global $session;

        $this->setUserName($session->get(Session::EMAIL));
        $this->setUserId($session->get(Session::ID));
        $this->iv = $session->get(Session::IV);
        $this->posts = Database::getPosts();
    }

    public function deletePost($encryptedPostId) {
        $post_id = $this->getDecryptedPostId($encryptedPostId);

        if ($this->isPostIdAuthor($post_id)) {
            Database::deletePost($post_id);
        }
    }

    public function editPost($encryptedPostId, $content) {
        $post_id = $this->getDecryptedPostId($encryptedPostId);
        if ($this->isPostIdAuthor($post_id)) {
            Database::updatePost($post_id, $content);
        }
    }

    public function createPost($content) {
        Database::createPost($this->userId, $content);
    }

    private function find($postId): Post {

        $this->posts = Database::getPosts();

        foreach ($this->posts as $post) {
            /* @var $post Post */
            if ($post->getId() == $postId) {
                return $post;
            }
        }
        return null;
    }

    public function isPostIdAuthor($postId) {
        /* @var $post Post */
        $post = $this->find($postId);
        return ($post != null && $this->userId == $post->getAuthor()->getId());
    }

    public function isPostAuthor(Post $post) {
        return $this->getUserName() == $post->getAuthor()->getEmail();
    }

    public function getEncryptedPostId(Post $post) {
        return EncryptionManager::encrypt($post->getId(), $this->iv);
    }

    public function getDecryptedPostId($postId) {
        return EncryptionManager::decrypt($postId, $this->iv);
    }

    /**
     * @return null|string
     */
    public function getUserName() {
        return htmlentities($this->userName);
    }

    /**
     * @param null|string $userName
     */
    public function setUserName($userName) {
        $this->userName = $userName;
    }

    /**
     * @return null|string
     */
    public function getUserId() {
        return htmlentities($this->userId);
    }

    /**
     * @param null|string $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts) {
        $this->posts = $posts;
    }

}