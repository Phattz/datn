

<?php


class AdminColorController {
    private $color;
    private $data;
    

    private $logModel;

    public function __construct() {
    $this->color = new ColorModel();      // Khởi tạo model màu
    $this->logModel = new AdminLogModel(); // Khởi tạo model ghi log nếu cần
}


    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewColor() {
    $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $searchKey = $_GET['search'] ?? '';

    if (!empty($searchKey)) {
        $totalColors = $this->color->countSearchColors($searchKey);
        $listcolor   = $this->color->searchColors($searchKey, $limit, $offset);
    } else {
        $totalColors = $this->color->getTotalColors();
        $listcolor   = $this->color->getColorsPaginated($page, $limit);
    }

    $this->data['listcolor']    = $listcolor;
    $this->data['totalPages']   = ceil($totalColors / $limit);
    $this->data['currentPage']  = $page;
    $this->data['searchKey']    = $searchKey;

    $this->renderView('color', $this->data);
}


    function viewAddColor(){
        $this->renderView('colorAdd');
    }

    function addColor(){
        if (isset($_POST['submit'])) {
            $nameColor = trim($_POST['nameColor']);
            
            if (empty($nameColor)) {
                $_SESSION['cart_message'] = [
                    'type' => 'error',
                    'text' => 'Tên màu không được để trống!'
                ];
                
                header("Location: ?page=color");
                exit();
            }

            $newId = $this->color->insertColor($nameColor);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'colors',
                'record_id' => $newId,
                'description' => "Thêm màu mới: {$nameColor} (ID: {$newId})"
            ]);
            
            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Thêm màu thành công!'
            ];
            
            header("Location: ?page=color");
            exit();
        }
    }

    function viewEditColor(){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = (int)$_GET['id'];
            $this->data['color'] = $this->color->getColorById($id);
            if ($this->data['color']) {
                $this->renderView('colorEdit', $this->data);
                return;
            }
        }
        echo '<script>alert("Màu không tồn tại");location.href="?page=color";</script>';
    }

    function updateColor(){
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $nameColor = trim($_POST['nameColor']);
            
            if (empty($nameColor)) {
                echo '<script>alert("Tên màu không được để trống!");</script>';
                echo '<script>location.href="?page=editcolor&id=' . $id . '";</script>';
                return;
            }

            $this->color->updateColor($id, $nameColor);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'update',
                'table_name' => 'colors',
                'record_id' => $id,
                'description' => "Cập nhật màu: {$nameColor} (ID: {$id})"
            ]);
            
            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Cập nhật màu thành công!'
            ];
            
            header("Location: ?page=color");
            exit();
        }
    }

}
