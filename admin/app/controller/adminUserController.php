<?php
class UserController
{
    private $userModel;
    private $logModel;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->logModel = new AdminLogModel();
    }

    // Hàm này để trả về Require_one
    function renderView($view, $data = [])
    {
        extract($data);
        $view = 'app/view/' . $view . '.php';
        require_once $view;
    }

    // Hàm này để hiển thị tất cả người dùng
    function viewUser()
    {
        $viTriTrangHienTai = 1 ;
        if(isset($_GET['currentPage'])){
            $viTriTrangHienTai = (int) $_GET['currentPage'];
        }
        if($viTriTrangHienTai < 1){
            $viTriTrangHienTai = 1;
        }
        
        // số người dùng hiển tị lên
        $viewUser = 9;
        $batDau = ($viTriTrangHienTai -1) * $viewUser;
        $usersDB = $this->userModel->getAllUser($batDau, $viewUser);
        foreach ($usersDB as &$user) {
            $roleHtml = '';
            if ($user['role'] === 0) {
                $roleHtml = 'Người dùng';
            } else if ($user['role'] === 1) {
                $roleHtml = 'Quản trị';
            }
            $user['role'] = $roleHtml;
            $activeHtml = '';
            if ($user['active'] === 0) {
                $activeHtml = '<span class="status pending">Chưa kích hoạt</span>';
            } else if ($user['active'] === 1) {
                $activeHtml = '<span class="status success">Đã kích hoạt</span>';
            } else if ($user['active'] === 2) {
                $activeHtml = '<span class="status danger">Đã chặn</span>';
            }
            $user['active'] = $activeHtml;
        }
        $tongUser = $this->userModel->tongUser();
        $tongPage = ceil($tongUser / $viewUser);

        $phamViTrang = 3;
        $batDauTrang = max(1, $viTriTrangHienTai - $phamViTrang);
        $cuoiTrang = min($tongPage, $viTriTrangHienTai + $phamViTrang);

        $this->renderView('user', 
        [
            'usersDB' => $usersDB,
            'viTriHienTai' => $viTriTrangHienTai,
            'batDauTrang' => $batDauTrang,
            'cuoiTrang' => $cuoiTrang,
            'tongPage' => $tongPage
        ]);
    }

    function adminSearchUser(){
        $searchKey = isset($_GET['search']) && !empty(trim($_GET['search'])) ? trim($_GET['search']) : null;
        echo $searchKey;
        $dataView = [];
        $key = $searchKey;
        $viTriHienTai = isset($_GET['currentPage']) && is_numeric($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;
        $viTriHienTai = max(1, $viTriHienTai);
        $soLuongTimKiem = 9;
        $batDau = ($viTriHienTai - 1) * $soLuongTimKiem;
        $dataView = $this->userModel->adminSearchUser($key, $batDau, $soLuongTimKiem);
        foreach ($dataView as &$user) {
            $roleHtml = '';
            if ($user['role'] === 0) {
                $roleHtml = 'Người dùng';
            } else if ($user['role'] === 1) {
                $roleHtml = 'Quản trị';
            }
            $user['role'] = $roleHtml;
            $activeHtml = '';
            if ($user['active'] === 0) {
                $activeHtml = '<span class="status pending">Chưa kích hoạt</span>';
            } else if ($user['active'] === 1) {
                $activeHtml = '<span class="status success">Đã kích hoạt</span>';
            } else if ($user['active'] === 2) {
                $activeHtml = '<span class="status danger">Đã chặn</span>';
            }
            $user['active'] = $activeHtml;
        }
        $tongPost = $this->userModel->tongUser();
        $tongPage = ceil($tongPost / $soLuongTimKiem);

        $phamViTrang = 1;
        $trangBatDau = max(1, $viTriHienTai - $phamViTrang);
        $trangKetThuc = min($tongPage, $viTriHienTai + $phamViTrang);
        $this->renderView('adminSearchUser', [
            'dataSearch' => $dataView,
            'key' => $key,
            'viTriHienTai' =>$viTriHienTai,
            'trangBatDau' => $trangBatDau,
            'trangKetThuc' => $trangKetThuc,
            'tongPage' => $tongPage
        ]);
    }

    // Hàm này để thêm người dùng vào DB
    function addUser()
    {
        $error = [];
        $data = [];
        if (isset($_POST['submitAddUser'])) {
            $data['email'] = $_POST['emailNGuoiDung'];
            $data['password'] = $_POST['passNguoiDung'];
            $rePasswordUser = $_POST['xacNhanPassNguoiDung'];
            $data['name'] = $_POST['tenNguoiDung'];
            $data['role'] = $_POST['role'];
            $data['active'] = $_POST['activeNguoiDung'];
            //Kiểm tra các ô input
            $error['name'] = (empty($data['name'])) ? 'Tên không được để trống' : '';
            $error['email'] = (empty($data['email'])) ? 'Email không được để trống' : ((filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) ? 'Không phải là Email' : '');
            $error['password'] = (empty($data['password'])) ? 'Mật khẩu không được để trống' : '';
            $error['rePassword'] = (empty($rePasswordUser)) ?
                'Xác nhận mật khẩu không được để trống' : (($data['password'] !== $rePasswordUser) ? 'Xác nhận mật khẩu và mật khẩu không khớp' : '');
            // thêm người dùng nếu không có lỗi
            if (empty($error['name']) && empty($error['email']) && empty($error['password']) && empty($error['rePassword'])) {
                $data['password'] = md5($data['password']);
                $newId = $this->userModel->insertUser($data, ''); //kh the them ng dung
                
                // Ghi log
                $this->logModel->addLog([
                    'action' => 'add',
                    'table_name' => 'users',
                    'record_id' => $newId,
                    'description' => "Thêm người dùng mới: {$data['name']} ({$data['email']}) (ID: {$newId})"
                ]);
                
                $_SESSION['cart_message'] = [
                    'type' => 'success',
                    'text' => 'Thêm người dùng thành công!'
                ];
                
                header("Location: ?page=product");
                exit();
                            
            }
        }
        $this->renderView('userAdd', ['error' => $error, 'data' => $data]);
    }
    // HÀM NÀY ĐỂ HIỂN THỊ THÔNG TIN CẦN CHỈNH SỬA NGƯỜI DÙNG
    function viewEditUser()
    {
        if (isset($_GET['id']) && ($_GET['id'] > 0)) {
            $id = $_GET['id'];
            $userID = $this->userModel->getUser($id);
            $this->renderView('userEdit', ['userID' => $userID]);
        }
    }


    // HÀM NÀY ĐỂ CHỈNH SỬA NGƯỜI DÙNG
    function editUser()
    {
        $data = [];
        $error = [];
        if (isset($_POST['submitEditUser'])) {
            $data['email'] = $_POST['emailNguoiDung'];
            $data['name'] = $_POST['tenNguoiDung'];
            $data['role'] = $_POST['role'];
            $data['active'] = $_POST['activeNguoiDung'];
            $data['id'] = $_POST['idNguoiDung'];
            $error['name'] = (empty($data['name'])) ? 'Tên không được để trống' : '';
            $error['email'] = (empty($data['email'])) ? 'Email không được để trống' : ((filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) ? 'Không phải là Email' : '');
            if (empty($error['name']) && empty($error['email'])) {
                $this->userModel->editUser($data);
                
                // Ghi log
                $this->logModel->addLog([
                    'action' => 'update',
                    'table_name' => 'users',
                    'record_id' => $data['id'],
                    'description' => "Cập nhật người dùng: {$data['name']} ({$data['email']}) (ID: {$data['id']})"
                ]);
                
                $_SESSION['cart_message'] = [
                    'type' => 'success',
                    'text' => 'Cập nhật người dùng thành công!'
                ];
                
                header("Location: ?page=user");
                exit();
            }
            $userID = $data;
        }
        $this->renderView('userEdit', ['error' => $error, 'userID' => $userID]);
    }

    function delUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy danh sách ID tài khoản từ form
            $deleteIds = $_POST['delete_ids'] ?? [];
            if (!empty($deleteIds)) {
                foreach ($deleteIds as $id) {
                    // Kiểm tra xem tài khoản có tồn tại không trước khi xóa
                    $user = $this->userModel->getUser($id);
                    if ($user) {
                        $userName = $user['name'] ?? 'N/A';
                        $userEmail = $user['email'] ?? 'N/A';
                        
                        // Xóa tài khoản khỏi cơ sở dữ liệu
                        $this->userModel->deleteUser($id);
                        
                        // Ghi log
                        $this->logModel->addLog([
                            'action' => 'delete',
                            'table_name' => 'users',
                            'record_id' => $id,
                            'description' => "Xóa người dùng: {$userName} ({$userEmail}) (ID: {$id})"
                        ]);
                    }
                }
                $_SESSION['cart_message'] = [
                    'type' => 'success',
                    'text' => 'Xoá tài khoản thành công!'
                ];
                
                header("Location: ?page=user");
                exit();
                 } else {
                $_SESSION['cart_message'] = [
                    'type' => 'error',
                    'text' => 'Không có tài khoản để xóa!'
                ];
            }
        }
    }
}