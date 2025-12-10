<?php
class AdminBannerController {
    private $banner;
    private $data;

    private $logModel;

    function __construct(){
        $this->banner = new BannerModel();
        $this->logModel = new AdminLogModel();
    }

    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewBanner(){
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 5;
        $totalBanners = $this->banner->getTotalBanners();
        $totalPages = ceil($totalBanners / $limit);
        
        $this->data['listbanner'] = $this->banner->getBannersPaginated($page, $limit);
        $this->data['totalPages'] = $totalPages;
        $this->data['currentPage'] = $page;
        
        $this->renderView('banner', $this->data);
    }

    function viewAddBanner(){
        $this->renderView('bannerAdd');
    }

    function addBanner(){
        if (isset($_POST['submit'])) {
            $data = [];
            $data['title'] = $_POST['title'] ?? '';
            $data['description'] = $_POST['description'] ?? '';
            $data['status'] = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $data['link'] = $_POST['link'] ?? '';

            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $data['image']);
            } else {
                echo '<script>alert("Vui lòng chọn ảnh banner!");</script>';
                echo '<script>location.href="?page=viewaddbanner";</script>';
                return;
            }

            $newId = $this->banner->insertBanner($data);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'banners',
                'record_id' => $newId,
                'description' => "Thêm banner mới: {$data['title']} (ID: {$newId})"
            ]);
            
            echo '<script>alert("Thêm banner thành công!");</script>';
            echo '<script>location.href="?page=banner";</script>';
        }
    }

    function viewEditBanner(){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = (int)$_GET['id'];
            $this->data['banner'] = $this->banner->getBannerById($id);
            if ($this->data['banner']) {
                $this->renderView('bannerEdit', $this->data);
                return;
            }
        }
        echo '<script>alert("Banner không tồn tại");location.href="?page=banner";</script>';
    }

    function updateBanner(){
        if (isset($_POST['submit'])) {
            $data = [];
            $data['id'] = $_POST['id'];
            $data['title'] = $_POST['title'] ?? '';
            $data['description'] = $_POST['description'] ?? '';
            $data['status'] = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $data['link'] = $_POST['link'] ?? '';

            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $data['image']);
                
                // Xóa ảnh cũ nếu có
                if (!empty($_POST['image_old'])) {
                    $oldImagePath = "../public/image/" . $_POST['image_old'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } else {
                // Giữ ảnh cũ
                $data['image'] = $_POST['image_old'];
            }

            $this->banner->updateBanner($data);
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'update',
                'table_name' => 'banners',
                'record_id' => $data['id'],
                'description' => "Cập nhật banner: {$data['title']} (ID: {$data['id']})"
            ]);
            
            echo '<script>alert("Cập nhật banner thành công!");</script>';
            echo '<script>location.href="?page=banner";</script>';
        }
    }

    function delBanner(){
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            foreach ($_POST['delete_ids'] as $id) {
                $banner = $this->banner->getBannerById($id);
                $bannerTitle = $banner['title'] ?? 'N/A';
                
                if ($banner && !empty($banner['image'])) {
                    $imagePath = "../public/image/" . $banner['image'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $this->banner->deleteBanner($id);
                
                // Ghi log
                $this->logModel->addLog([
                    'action' => 'delete',
                    'table_name' => 'banners',
                    'record_id' => $id,
                    'description' => "Xóa banner: {$bannerTitle} (ID: {$id})"
                ]);
            }
            echo '<script>alert("Đã xóa banner!");</script>';
            echo '<script>location.href="?page=banner";</script>';
        }
    }
}
