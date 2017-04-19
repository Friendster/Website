<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 19-Apr-17
 * Time: 18:45
 */
class user {
    private $id;
    private $name;
    private $pass;

    /**
     * user constructor.
     * @param $id
     * @param $name
     * @param $pass
     */
    public function __construct($id, $name, $pass) {
        $this->id = $id;
        $this->name = $name;
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
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
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPass() {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass) {
        $this->pass = $pass;
    }


}