<?php
class ProductController
{
    private $products;
    private $category;
    private $comment;
    private $rating;
    private $data;

    function __construct()
    {
        $this->products = new ProductsModel();
        $this->category = new CategoriesModel();
        $this->comment = new ProductCommentModel();
        $this->rating = new RatingModel();
    }

    function renderView($view, $data)
    {
        $view = 'app/view/' . $view . '.php';
        require_once $view;
    }

    function viewProCate()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $idcate = $_GET['id'];

            $this->data['products'] = $this->products->getProductsByCategoryWithDefaultPrice($idcate);

            $this->data['prohot']    = $this->products->getProHot();
            $this->data['nameCate']  = $this->category->getNameCateUser($idcate);
            $this->data['cate']      = $this->category->getAllCate();

            return $this->renderView('product', $this->data);
        } else {
            echo 'Not found category';
        }
    }

    function viewProDetail()
    {
        if (isset($_GET['id'])) {

            $idpro = $_GET['id'];

            // Thông tin sản phẩm
            $this->data['detail']     = $this->products->getIdPro($idpro);
            $this->data['nameCate']   = $this->products->getNameCate($idpro);

            // Các biến thể
            $this->data['sizes']      = $this->products->getSizesByProduct($idpro);
            $this->data['colors']     = $this->products->getColorsByProduct($idpro);
            
            // Sản phẩm liên quan
            $result = $this->products->getIdCate($idpro);
            $this->data['splq'] = $this->products->getRelatedWithDefaultPrice($result['idCategory'], $idpro);


            // Bình luận + đánh giá
            $this->data['comment'] = $this->comment->getComment($idpro);
            $this->data['rating']  = $this->rating->getRating($idpro);

            return $this->renderView('productDetail', $this->data);
        } else {
            echo "Not found product";
        }
    }


    
    

    

    function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['idProduct'] = $_POST['idProduct'];
            $data['idUser'] = $_SESSION['user'];
            $data['text'] = trim($_POST['comment_text']);
            $this->comment->addComment($data);

            echo "<script>alert('Thêm bình luận thành công')</script>";
            echo '<script>location.href="?page=productDetail&id=' . $data['idProduct'] . '"</script>';
        }
    }
}
