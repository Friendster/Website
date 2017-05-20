<?php


class AppController {
    private $model;

    public function __construct(AppModel $model) {
        $this->model = $model;
    }
}