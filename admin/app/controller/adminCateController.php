<?php
class CateAdminController
{
    private $data = [];
    private $category;
    private $product;

    private $logModel;

    function __construct()
    {
        $this->category = new CategoriesModel();
        $this->product = new ProductsModel();
        $this->logModel = new AdminLogModel();
    }

    // View mặc định
    function view($data)
    {
        require_once './app/view/category.php';
    }

    function renderView($view, $data = null)
    {
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    // Danh sách danh mục có phân trang
    function viewCategory()
    {
        $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 4;

        $totalCates  = $this->category->getTotalCates();
        $totalPages  = ceil($totalCates / $limit);

        $this->data['listcate']    = $this->category->getCatesPaginated($page, $limit);
        $this->data['totalPages']  = $totalPages;
        $this->data['currentPage'] = $page;

        $this->renderView('category', $this->data);
    }

    // View thêm danh mục
    function viewAddCate()
    {
        $this->renderView('categoryAdd');
    }

    // View sửa danh mục
    function viewEditCate()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = (int)$_GET['id'];
            $this->data['type'] = $this->category->getIdCate($id);
            $this->renderView('categoryEdit', $this->data);
            return;
        }

        echo '<script>alert("Danh mục không tồn tại");location.href="?page=category";</script>';
    }

    // Cập nhật danh mục
    function updateCate()
    {
        if (isset($_POST['submit'])) {
            $data = [
                'id'     => $_POST['id'],
                'name'   => trim($_POST['name']),
                'status' => $_POST['status'],
            ];

            $this->category->upCate($data);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'update',
                'table_name' => 'categories',
                'record_id' => $data['id'],
                'description' => "Cập nhật danh mục: {$data['name']} (ID: {$data['id']})"
            ]);

            echo '<script>alert("Đã sửa danh mục thành công");location.href="?page=category";</script>';
        }
    }

    // Thêm danh mục
    function addCate()
    {
        if (isset($_POST['submit'])) {
            $data = [
                'name'   => trim($_POST['name']),
                'status' => $_POST['status']
            ];

            $newId = $this->category->insertCate($data);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'categories',
                'record_id' => $newId,
                'description' => "Thêm danh mục mới: {$data['name']} (ID: {$newId})"
            ]);

            echo '<script>alert("Đã thêm danh mục thành công");location.href="?page=category";</script>';
        }
    }

    // Xóa danh mục
    public function delCate()
    {
        if (!isset($_POST['delete_ids']) || empty($_POST['delete_ids'])) {
            echo '<script>alert("Vui lòng chọn ít nhất một danh mục để xóa!");location.href="?page=category";</script>';
            return;
        }

        foreach ($_POST['delete_ids'] as $id) {

            // Kiểm tra danh mục còn sản phẩm không
            $linkedProducts = $this->product->get_all_pro_cate($id);

            if (count($linkedProducts) > 0) {
                echo '<script>alert("Không thể xóa danh mục ID: ' . $id . ' vì đang liên kết với sản phẩm!");</script>';
                continue;
            }

            // Lấy thông tin danh mục trước khi xóa
            $cate = $this->category->getIdCate($id);
            $cateName = $cate['name'] ?? 'N/A';
            
            // Xóa vì không còn liên kết
            $this->category->deleteCate($id);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'delete',
                'table_name' => 'categories',
                'record_id' => $id,
                'description' => "Xóa danh mục: {$cateName} (ID: {$id})"
            ]);
        }

        echo '<script>alert("Đã xử lý xóa danh mục!");location.href="?page=category";</script>';
    }
}
