<?php
class PostController{
    private $post;
    private $postCate;
    function __construct(){
        $this->post = new PostModel();
    }
    
    function renderView($view, $data){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }

    function viewPost(){
        $data['posts'] = $this->post->getPost(0,0);
        $this->renderView('post', $data);
    }

    function viewPostDetail(){
        if(isset($_GET['id']) && $_GET['id'] >0){
            $idpost = $_GET['id'];
            $idCatePost = $this->post->getIdCatePost($idpost);
            $data['postCate'] = $this->post->getPostByIdCate($idCatePost['idCatePost']);
            $data['post'] = $this->post->getPostById($idpost);
            $this->renderView('postDetail', $data);
        }
    }
}