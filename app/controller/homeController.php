<?php
class HomeController{
    private $product;
    private $category;
    private $post;
    private $banner;
    private $data;
   
    function __construct(){
        $this->product = new ProductsModel();
        $this->category = new ProductCateModel();
        $this->post = new PostModel();
        $this->banner = new BannerModel();
    }
    
    function renderView($view, $data){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }

    function viewHome(){
        $this->data['product8'] = $this->product->getQuantityPro(0,8);
        $this->data['product6'] = $this->product->get6Pro();
        $this->data['post'] = $this->post->getPost(0,3);
        $this->data['banner'] = $this->banner->getBanner();
        return $this->renderView('home', $this->data);
    }

    //hiện trang giới thiệu
    function viewAbout(){
        return $this->renderView('about', $this->data);
    }


}