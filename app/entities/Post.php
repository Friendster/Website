<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 15:48
 */
class Post {

    private $id;
    private $author;
    private $content;
    private $date;

    /**
     * Post constructor.
     * @param $id
     * @param $author
     * @param $content
     * @param $date
     */
    public function __construct($id, User $author, $content, $date) {
        $this->setId($id);
        $this->setAuthor($author);
        $this->setContent($content);
        $this->setDate($date);
    }

    /**
     * @return mixed
     */
    public function getId() {
        return htmlentities($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAuthor() : User {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(User $author) {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return htmlentities($this->content);
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return htmlentities($this->date);
    }

    /**
     * @param mixed $date
     */
    public function setDate($date) {
        $this->date = $date;
    }


}