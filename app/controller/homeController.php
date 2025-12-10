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
        $this->data = []; // Luôn khởi tạo
    }
    
    function renderView($view, $data){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }

    function viewHome(){

        // ============================
        // LẤY 8 SẢN PHẨM MỚI NHẤT
        // ============================
        $products = $this->product->getNewProducts();

        foreach ($products as &$p) {
    $variant = $this->product->getDefaultColor($p['id']);
    if ($variant && isset($variant['idColor'])) {
        $p['idColor'] = $variant['idColor'];
    } else {
        $p['idColor'] = null; // hoặc gán giá trị mặc định
    }
}


        $this->data['product8'] = $products;


        // ============================
        // LẤY 6 SẢN PHẨM NỔI BẬT (theo view DESC)
        // ============================
        $hots = $this->product->getHotProducts(6);

        foreach ($hots as &$p) {
            // Lấy idColor mặc định
            $variant = $this->product->getDefaultColor($p['id']);
            $p['idColor'] = $variant['idColor'];
        }

        $this->data['product6'] = $hots;


        // ============================
        // LẤY BANNER
        // ============================
        $this->data['banner'] = $this->banner->getBanner();


        // ============================
        // RENDER HOME VIEW
        // ============================
        return $this->renderView('home', $this->data);
    }
}
