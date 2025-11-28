<?php
class HomeController{
    private $product;
    private $category;
    private $banner;
    private $data;
   
    function __construct(){
        $this->product = new ProductsModel();
        $this->category = new CategoriesModel();
        $this->banner = new BannerModel();
    }
    
    function renderView($view, $data){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }

    function viewHome(){
        $this->data['product8'] = $this->product->getProductsWithDefaultPrice(8);
        $this->data['product6'] = $this->product->getProductsWithDefaultPrice(6);
        $this->data['banner'] = $this->banner->getBanner();
        return $this->renderView('home', $this->data);
    }
    



}