<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 20-May-17
 * Time: 14:40
 */
class PostView {
    private $model;
    private $controller;

    public function __construct(PostController $controller, PostModel $model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output() {

    }
}