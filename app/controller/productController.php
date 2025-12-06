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
        $this->data = [];
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

            // Lấy SP theo danh mục
            $list = $this->products->getProductsByCategoryWithDefaultPrice($idcate);

            // Thêm idColor mặc định để tránh lỗi cart
            foreach ($list as &$p) {
                $variant = $this->products->getDefaultColor($p['id']);
                $p['idColor'] = $variant['idColor'];  
            }

            $this->data['products'] = $list;

            // Sản phẩm nổi bật
            $prohot = $this->products->getHotProducts();
            foreach ($prohot as &$item) {
                $variant = $this->products->getDefaultColor($item['id']);
                $item['idColor'] = $variant['idColor'];
            }
            $this->data['prohot'] = $prohot;

            // Danh mục
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

            // Tăng lượt xem
            $this->products->increaseView($idpro);

            // Chi tiết SP
            $this->data['detail']     = $this->products->getIdPro($idpro);
            $this->data['nameCate']   = $this->products->getNameCate($idpro);

            // Màu sắc
            $this->data['colors']     = $this->products->getColorsByProduct($idpro);

            // SP liên quan
            $result = $this->products->getIdCate($idpro);
            $this->data['splq'] = $this->products->getRelatedWithDefaultPrice($result['idCategory'], $idpro);

            // Bình luận & đánh giá
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
