<?php
class AdminColorController {
    private $color;
    private $data;

    private $logModel;

    

    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewColor(){
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 5;
        $totalColors = $this->color->getTotalColors();
        $totalPages = ceil($totalColors / $limit);
        
        $this->data['listcolor'] = $this->color->getColorsPaginated($page, $limit);
        $this->data['totalPages'] = $totalPages;
        $this->data['currentPage'] = $page;
        
        $this->renderView('color', $this->data);
    }

    function viewAddColor(){
        $this->renderView('colorAdd');
    }

    function addColor(){
        if (isset($_POST['submit'])) {
            $nameColor = trim($_POST['nameColor']);
            
            if (empty($nameColor)) {
                echo '<script>alert("Tên màu không được để trống!");</script>';
                echo '<script>location.href="?page=viewaddcolor";</script>';
                return;
            }

            $newId = $this->color->insertColor($nameColor);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'colors',
                'record_id' => $newId,
                'description' => "Thêm màu mới: {$nameColor} (ID: {$newId})"
            ]);
            
            echo '<script>alert("Thêm màu thành công!");</script>';
            echo '<script>location.href="?page=color";</script>';
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
            
            echo '<script>alert("Cập nhật màu thành công!");</script>';
            echo '<script>location.href="?page=color";</script>';
        }
    }

    function delColor(){
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $deleted = 0;
            $failed = 0;
            
            foreach ($_POST['delete_ids'] as $id) {
                $color = $this->color->getColorById($id);
                $colorName = $color['nameColor'] ?? 'N/A';
                
                if ($this->color->deleteColor($id)) {
                    $deleted++;
                    
                    // Ghi log
                    $this->logModel->addLog([
                        'action' => 'delete',
                        'table_name' => 'colors',
                        'record_id' => $id,
                        'description' => "Xóa màu: {$colorName} (ID: {$id})"
                    ]);
                } else {
                    $failed++;
                }
            }
            
            if ($failed > 0) {
                echo '<script>alert("Đã xóa ' . $deleted . ' màu. ' . $failed . ' màu không thể xóa vì đang được sử dụng!");</script>';
            } else {
                echo '<script>alert("Đã xóa ' . $deleted . ' màu!");</script>';
            }
            echo '<script>location.href="?page=color";</script>';
        }
    }
}
