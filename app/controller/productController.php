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
        $this->productComment = new ProductCommentModel();
        $this->rating = new RatingModel();
        $this->data = [];
    }

    function renderView($view, $data)
{
    if (is_array($data)) {
        extract($data);
    }
    $view = 'app/view/' . $view . '.php';
    require_once $view;
}


    function viewProCate()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $idcate = $_GET['id'];

            // Lấy SP theo danh mục
            $list = $this->products->getProductsByCategoryWithDefaultPrice($idcate);

            // Thêm idColor mặc định cho mỗi sản phẩm
            foreach ($list as &$p) {
                $variant = $this->products->getDefaultColor($p['id']);
                $p['idColor'] = $variant['idColor'];
            }

            $this->data['products'] = $list;

            // Lấy sản phẩm nổi bật
            $prohot = $this->products->getHotProducts();
            foreach ($prohot as &$item) {
                $variant = $this->products->getDefaultColor($item['id']);
                $item['idColor'] = $variant['idColor'];
            }
            $this->data['prohot'] = $prohot;

            // Danh mục
            $this->data['nameCate'] = $this->category->getNameCateUser($idcate);
            $this->data['cate']     = $this->category->getAllCate();

            return $this->renderView('product', $this->data);
        }

        echo "Not found category";
    }

    function viewProDetail()
{
    if (!isset($_GET['id'])) {
        echo "Not found product";
        return;
    }

    $idpro = $_GET['id'];

    // Tăng lượt xem
    $this->products->increaseView($idpro);

    // Chi tiết SP
    $this->data['detail']   = $this->products->getIdPro($idpro);
    $this->data['nameCate'] = $this->products->getNameCate($idpro);
    //lấy danh sách bình luận
    $this->data['comments'] = $this->productComment->getCommentsByProduct($idpro);
    // Màu sắc
    $this->data['colors'] = $this->products->getColorsByProduct($idpro);


    // ============================
//        PHÂN TRANG ĐÁNH GIÁ
// ============================

// Số đánh giá mỗi trang
$limit = 3;

// Trang hiện tại
$page = isset($_GET['pageRate']) ? max(1, intval($_GET['pageRate'])) : 1;

// Offset
$offset = ($page - 1) * $limit;

// Tổng số đánh giá
$totalRating = $this->rating->getRatingTotal($idpro)['total'];

// Tổng số trang
$totalPages = ceil($totalRating / $limit);

// Lấy đánh giá theo phân trang
$this->data['ratingPage'] = $this->rating->getRatingPaginate($idpro, $limit, $offset);

// Biến gửi sang view
$this->data['currentPage'] = $page;
$this->data['totalPages']  = $totalPages;
$this->data['totalRating'] = $totalRating;

// Thống kê sao
$this->data['ratingStats'] = $this->rating->getRatingStats($idpro);

// Trung bình sao + tổng
$this->data['ratingInfo']  = $this->rating->getRatingSummary($idpro);



    // =================================
    //        SẢN PHẨM LIÊN QUAN
    // =================================
    $result = $this->products->getIdCate($idpro);
    if ($result && isset($result['idCategory'])) {
        $this->data['splq'] = $this->products->getRelatedWithDefaultPrice(
            $result['idCategory'],
            $idpro
        );
    } else {
        $this->data['splq'] = [];
    }

    return $this->renderView('productDetail', $this->data);
}

    function addComment()
    {
        if (!isset($_POST['sendComment'])) return;

        $idProduct = $_POST['idProduct'];
        $text      = $_POST['text'];

        if (!empty($_SESSION['user'])) {
            $idUser = $_SESSION['user'];
            $guestName = null;
        } else {
            $idUser = null;
            $guestName = $_POST['guestName'];
        }

        $data = [
            'idProduct' => $idProduct,
            'idUser'    => $idUser,
            'guestName' => $guestName,
            'text'      => $text,
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

?>
