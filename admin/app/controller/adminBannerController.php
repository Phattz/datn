<?php
class AdminBannerController {
    private $banner;
    private $data;
    private $logModel;

    function __construct(){
        $this->banner = new BannerModel();
        $this->logModel = new AdminLogModel();
        $this->data = [];
    }

    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        if ($data) {
            extract($data);
        }
        require_once $view;
    }

    // ======================
    // DANH SÁCH BANNER
    // ======================
    function viewBanner(){
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 5;

        $totalBanners = $this->banner->getTotalBanners();
        $totalPages = ceil($totalBanners / $limit);

        $this->data['listbanner']   = $this->banner->getBannersPaginated($page, $limit);
        $this->data['totalPages']   = $totalPages;
        $this->data['currentPage']  = $page;

        $this->renderView('banner', $this->data);
    }

    // ======================
    // VIEW THÊM BANNER
    // ======================
    function viewAddBanner(){
        $this->renderView('bannerAdd');
    }

    // ======================
    // THÊM BANNER (CHỈ IMAGE)
    // ======================
    function addBanner(){
        if (isset($_POST['submit'])) {

            if (empty($_FILES['image']['name'])) {
                echo '<script>alert("Vui lòng chọn ảnh banner!");location.href="?page=viewaddbanner";</script>';
                return;
            }

            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $image);

            $newId = $this->banner->insertBanner([
                'image' => $image
            ]);

            // Log (không còn title)
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'banner',
                'record_id' => $newId,
                'description' => "Thêm banner mới (ID: {$newId})"
            ]);

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Thêm banner thành công!'
            ];
            
            header("Location: ?page=banner");
            exit();
        }
    }

    // ======================
    // VIEW SỬA BANNER
    // ======================
    function viewEditBanner(){
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = (int)$_GET['id'];
            $this->data['banner'] = $this->banner->getBannerById($id);

            if ($this->data['banner']) {
                $this->renderView('bannerEdit', $this->data);
                return;
            }
        }
        $_SESSION['cart_message'] = [
            'type' => 'error',
            'text' => 'Banner không tồn tại!'
        ];
        
        header("Location: ?page=banner");
        exit();
    }

    // ======================
    // CẬP NHẬT BANNER (CHỈ IMAGE)
    // ======================
    function updateBanner(){
        if (isset($_POST['submit'])) {

            $id = $_POST['id'];
            $image = $_POST['image_old'];

            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $image);

                // Xóa ảnh cũ
                if (!empty($_POST['image_old'])) {
                    $oldPath = "../public/image/" . $_POST['image_old'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }
            }

            $this->banner->updateBanner([
                'id'    => $id,
                'image' => $image
            ]);

            $this->logModel->addLog([
                'action' => 'update',
                'table_name' => 'banner',
                'record_id' => $id,
                'description' => "Cập nhật banner (ID: {$id})"
            ]);

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Cập nhật banner thành công!'
            ];
            
            header("Location: ?page=banner");
            exit();
        }
    }

    // ======================
    // XÓA BANNER
    // ======================
    function delBanner(){
        if (!empty($_POST['delete_ids'])) {
            foreach ($_POST['delete_ids'] as $id) {

                $banner = $this->banner->getBannerById($id);
                if ($banner && !empty($banner['image'])) {
                    $path = "../public/image/" . $banner['image'];
                    if (file_exists($path)) unlink($path);
                }

                $this->banner->deleteBanner($id);

                $this->logModel->addLog([
                    'action' => 'delete',
                    'table_name' => 'banner',
                    'record_id' => $id,
                    'description' => "Xóa banner (ID: {$id})"
                ]);
            }
            echo '<script>alert("Đã xóa banner!");location.href="?page=banner";</script>';
        }
    }
}
