<?php

class PostController {
    private $model;

    public function __construct(PostModel $model) {
        $this->model = $model;
    }

    public function onEdit() {
        global $session;
        if (isset($_POST["edit"])&& $_POST["token"] == $session->get(Session::TOKEN)) {
            $this->model->editPost($_POST["id"], $_POST["edit-content"]);
            RouteManager::navigate();
        }
    }

    public function onDelete() {
        global $session;
        if (isset($_POST["delete"])&& $_POST["token"] == $session->get(Session::TOKEN)) {
            $this->model->deletePost($_POST["id"]);
            RouteManager::navigate();
        }
    }

    public function onCreate() {
        global $session;

        if (isset($_POST['create'])&& $_POST["token"] == $session->get(Session::TOKEN)) {
            $this->model->createPost($_POST['content']);
            RouteManager::navigate();

        }
    }
}