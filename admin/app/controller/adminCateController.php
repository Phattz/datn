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

        $_SESSION['cart_message'] = [
            'type' => 'error',
            'text' => 'Danh mục không tồn tại!'
        ];
        
        header("Location: ?page=category");
        exit();
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

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Cập nhật danh mục thành công!'
            ];
            
            header("Location: ?page=category");
            exit();
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

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Thêm danh mục thành công!'
            ];
            
            header("Location: ?page=category");
            exit();
        }
    }

}
