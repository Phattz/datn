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
        $this->category = new ProductCateModel();
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
            $this->data['products'] = $this->products->getProCate($idcate); //lấy sản phẩm cùng danh mục
            $this->data['prohot'] = $this->products->getProHot();  //lấy sản phẩm hot (view cao)
            $this->data['nameCate'] = $this->category->getNameCateUser($idcate);  //lấy tên danh mục theo id
            $this->data['cate'] = $this->category->getAllCate();
            return $this->renderView('product', $this->data);
        } else {
            echo 'Not found category';
        }
    }

    function viewProDetail()
    {
        if (isset($_GET['id'])) {
            $idpro = $_GET['id'];
            $this->data['detail'] = $this->products->getIdPro($idpro); //lấy chi tiết sản phẩm theo id
            $this->data['nameCate'] = $this->products->getNameCate($idpro); //lấy tên danh mục theo id sản phẩm
            //san pham lien quan 
            $result = $this->products->getIdCate($idpro);
            $this->data['splq'] = $this->products->getProCateById($result['idCate'], $idpro);
            $this->data['comment'] = $this->comment->getComment($idpro); //lấy bình luận sản phẩm theo id
            $this->data['rating'] = $this->rating->getRating($idpro); //lấy đánh giá sản phẩm
            return $this->renderView('productDetail', $this->data);
        } else {
            echo 'Not found product';
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