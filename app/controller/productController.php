<?php
class ProductController
{
    private $products;
    private $category;
    private $productComment;
    private $rating;
    private $data;

    function __construct()
    {
        $this->products = new ProductsModel();
        $this->category = new CategoriesModel();
        $this->productComment  = new ProductCommentModel();
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
            $this->data['comment'] = $this->productComment->getComment($idpro);
            $this->data['rating']  = $this->rating->getRating($idpro);

            return $this->renderView('productDetail', $this->data);
        } else {
            echo "Not found product";
        }
    }

    function addComment()
    {
        if (isset($_POST['sendComment'])) {

            $idProduct = $_POST['idProduct'];
            $text = $_POST['text'];

            // Nếu đã đăng nhập → dùng idUser + name từ session
            if (!empty($_SESSION['user'])) {

                $idUser = $_SESSION['user']['id'];
                $userName = $_SESSION['user']['name'];

            } else {
                // Khách vãng lai
                $idUser = 0; // mặc định 0 = guest
                $userName = $_POST['guestName'];
            }

            // Lưu bình luận
            $data = [
                'idProduct' => $idProduct,
                'idUser'    => $idUser,
                'text'      => $text,
                'guestName' => $userName
            ];

            $this->productComment->addComment($data);

            $_SESSION['cart_message'] = [
                "text" => "Gửi bình luận thành công!",
                "type" => "success"
            ];

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
}
