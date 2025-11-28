<?php
class CateAdminController
{
    private $data;
    private $category;
    private $product;

    function __construct()
    {
        $this->category = new CategoriesModel();
        $this->product = new ProductsModel();
    }

    //view giao diện
    function view($data)
    {
        require_once './app/view/category.php';
    }

    function renderView($view, $data = null)
    {
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewCategory()
    {
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 4;
        $totalCates = $this->category->getTotalCates();
        $totalPages = ceil($totalCates / $limit);
        $this->data['listcate'] = $this->category->getCatesPaginated($page, $limit);
        $this->data['totalPages'] = $totalPages;  // Thêm dòng này
        $this->data['currentPage'] = $page;  // Thêm dòng này nếu bạn cần sử dụng trang hiện tại trong view
        $this->renderView('category', $this->data);
    }

    function viewAddCate()
    {
        $this->renderView('categoryAdd');
    }

    function viewEditCate()
    {
        if (isset($_GET['id']) && ($_GET['id']) > 0) {
            $id = $_GET['id'];
            $this->data['type'] = $this->category->getIdCate($id);
            $this->renderView('categoryEdit', $this->data);
        }
    }

    function updateCate()
    {
        if (isset($_POST['submit'])) {
            $data = [];
            $data['id'] = $_POST['id'];
            $data['name'] = $_POST['name'];
            $data['status'] = $_POST['status'];
            $this->category->upCate($data);
            echo '<script>alert("Đã sửa danh mục thành công")</script>';
            echo '<script>location.href="?page=category"</script>';
        }
    }

    public function addCate()
    {
        if (isset($_POST['submit'])) {
            $data = [];
            $data['name'] = $_POST['name'];
            $data['status'] = $_POST['status'];
            $this->category->insertCate($data);
        }
        echo '<script>alert("Đã thêm danh mục thành công")</script>';
        echo '<script>location.href="?page=category"</script>';
    }

    // public function delCate()
    // {
    //     if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
    //         $deleteIds = $_POST['delete_ids'];
    //         // Duyệt qua từng id và xóa
    //         foreach ($deleteIds as $id) {
    //             $data = $this->product->get_all_pro_cate($id);
    //             if (count($data) > 0) {
    //                 echo '<script>alert("Không thể xóa danh mục này")</script>';
    //             } else {
    //                 $this->category->deleteCate($id);
    //             }    
    //         }
    //         echo '<script>alert("Đã xóa danh mục thành công")</script>';
    //         echo '<script>location.href="?page=category"</script>';
    //     }
    // }

    public function delCate()
    {
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $deleteIds = $_POST['delete_ids'];
            foreach ($deleteIds as $id) {
                // Kiểm tra nếu danh mục này còn liên kết với sản phẩm
                $data = $this->product->get_all_pro_cate($id);
                if (count($data) > 0) {
                    echo '<script>alert("Không thể xóa danh mục: ' . $id . ' vì đang liên kết với sản phẩm!")</script>';
                } else {
                    $this->category->deleteCate($id);
                }
            }
            echo '<script>alert("Đã xóa danh mục được chọn!")</script>';
            echo '<script>location.href="?page=category"</script>';
        } else {
            echo '<script>alert("Vui lòng chọn ít nhất một danh mục để xóa!")</script>';
            echo '<script>location.href="?page=category"</script>';
        }
    }
}
