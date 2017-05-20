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
        $output = '<div class="container-fluid"><div class="col-md-offset-3 col-md-6">';
        $output .= $this->submitOutput();

        $modalCounter = 0;
        foreach ($this->model->getPosts() as $post) {
            $modalCounter++;
            $output .= $this->postOutput($post, $modalCounter);
        }

        $output .= '</div></div>';

        return $output;
    }

    private function submitOutput() {
        return '<div class="panel panel-default">
            <div class="panel-heading">' . $this->model->getUserName() . '</div>
            <div class="panel-body">
                <form method="post" action="#" autocomplete="off">
                    <div class="form-group">
                         <textarea placeholder="Add a new post" name="content" class="form-control" rows="3" id="textArea"></textarea>
                    </div>
                    <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>';
    }

    private function postOutput(Post $post, $modalCount) {
        return '<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title col-xs-8 pull-left">' .
                    $post->getAuthor()->getEmail() .
                '</h3>' .
                $this->deleteButtonOutput($post) .
                $this->editButtonOutput($post, $modalCount) .
                '<div class="clearfix"></div>
            </div>
                        
            <div class="panel-body">' .
                $post->getContent() . '<br />' .
                $post->getDate() .
            '</div>' .

            $this->editModalOutput($post, $modalCount) .
        '</div>';
    }

    private function deleteButtonOutput(Post $post) {
        return ($this->model->isPostAuthor($post)) ?
            '<form method="post" action="#">
                    <input type="hidden" name="id" value=' . $this->model->getEncryptedPostId($post) . ' />

                    <button name="delete" type="submit" class="btn btn-danger pull-right btn-sm gap">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
      
                </form>' : '';
    }

    private function editButtonOutput($post, $modalCount) {
        return ($this->model->isPostAuthor($post)) ?
            '<a href="#edit-modal-' . $modalCount . '" data-toggle="modal">
                <button name="edit" class="btn btn-primary pull-right btn-sm">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
            </a>' : '';
    }

    private function editModalOutput(Post $post, $modalCount) {
        return ($this->model->isPostAuthor($post)) ?
            '<div id="edit-modal-' . $modalCount . '" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Edit Post</h4>
                            </div>                 
                            <div class="modal-body">            
                                <form action="#" method="post" class="form-vertical">
                                
                                    <input type="hidden" name="id" value=' . $this->model->getEncryptedPostId($post) . ' />
                                
                                    <div class="form-group">
                                        <textarea name="edit-content" class="form-control" rows="3" id="edit-text-area">' . $post->getContent() . '</textarea>
                                    </div>
                
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Save</button>
                                    </div>                                    
                                </form>                
                            </div>
                
                
                        </div>
                    </div>
                </div>' : '';
    }


}
