<?php

class PostController {
    private $model;

    public function __construct(PostModel $model) {
        $this->model = $model;
    }

    public function onEdit() {
        if (isset($_POST["edit"])) {
            $this->model->editPost($_POST["id"], $_POST["edit-content"]);
            navigate();
        }
    }

    public function onDelete() {
        if (isset($_POST["delete"])) {
            $this->model->deletePost($_POST["id"]);
            navigate();
        }
    }

    public function onCreate() {
        if (isset($_POST['submit'])) {
            $this->model->createPost($_POST['content']);
            navigate();

        }
    }
}