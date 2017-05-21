<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 15:54
 */
class User {
    private $id;
    private $email;
    private $name;

    /**
     * User constructor.
     * @param $id
     * @param $email
     * @param $name
     */
    public function __construct($id, $email, $name) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
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
    public function getEmail() {
        return htmlentities($this->email);
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return htmlentities($this->name);
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

}