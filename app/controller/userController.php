<?php
class UserController
{
    private $user;
    private $mailController;
    private $order;

    function __construct()
    {
        $this->user = new UserModel();
        $this->mailController = new MailerController();
        $this->order = new OrderModel();
    }

    function renderView($view, $data = [])
    {
        $view = 'app/view/' . $view . '.php';
        require_once $view;
    }

    /* ========================
       ĐĂNG KÝ
    ======================== */
    public function register()
    {
        if (isset($_POST['dangky'])) {

            $data['email'] = $_POST['re-email'];
            $password = $_POST['mk'];
            $repass = $_POST['remk'];
            $data['name'] = $_POST['hoten'];
            $data['phone'] = $_POST['sdt'];

            if ($password !== $repass) {
                echo "<script>alert('Mật khẩu không trùng khớp');location.href='index.php';</script>";
                return;
            }

            if ($this->user->checkmail($data['email'])) {
                echo "<script>alert('Email đã tồn tại');location.href='index.php';</script>";
                return;
            }

            // Mã hoá pass
            $data['password'] = md5($password);

            // Tạo mã xác thực
            $verificationCode = bin2hex(random_bytes(32));

            // Lưu DB
            $this->user->insertUser($data, $verificationCode);

            // Gửi mail xác thực
            $this->mailController->sendVerificationEmail($data['email'], $verificationCode);

            echo "<script>alert('Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');location.href='index.php';</script>";
        }
    }

    /* ========================
       ĐĂNG NHẬP
    ======================== */
    public function login()
    {
        if (!isset($_POST['dangnhap'])) {
            header("Location: index.php");
            exit;
        }

        $email = trim($_POST['email']);
        $password = md5($_POST['mklogin']);

        $result = $this->user->checkUser($email, $password);

        if (!is_array($result)) {
            $_SESSION['cart_message'] = [
                'text' => 'Sai email hoặc mật khẩu',
                'type' => 'error'
            ];
            header("Location: index.php");
            exit;
        }

        if ($result['active'] == 0) {
            $_SESSION['cart_message'] = [
                'text' => 'Bạn chưa xác thực email. Vui lòng kiểm tra hộp thư.',
                'type' => 'warning'
            ];
            header("Location: index.php");
            exit;
        }

        if ($result['active'] == 2) {
            $_SESSION['cart_message'] = [
                'text' => 'Tài khoản đã bị khóa',
                'type' => 'error'
            ];
            header("Location: index.php");
            exit;
        }

        $_SESSION['user'] = $result['id'];


        if ($result['role'] == 1) {
            $_SESSION['cart_message'] = [
                'text' => 'Đăng nhập Admin thành công',
                'type' => 'success'
            ];
            header("Location: admin/index.php");
            exit;
        }

        if (!empty($_POST['redirect'])) {
            header("Location: " . $_POST['redirect']);
            exit;
        }

        if (!empty($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
            exit;
        }

        $_SESSION['cart_message'] = [
            'text' => 'Đăng nhập thành công',
            'type' => 'success'
        ];
        header("Location: index.php");
        exit;
    }

    /* ========================
       GOOGLE SIGN IN
    ======================== */
    public function googleLogin(): void
    {
        header('Content-Type: application/json');

        $rawBody = file_get_contents('php://input');
        $payload = json_decode($rawBody, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
            $payload = $_POST; // fallback khi không gửi JSON
        }

        $credential = $payload['credential'] ?? '';
        if (empty($credential)) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu mã xác thực Google.'
            ]);
            return;
        }

        $clientId = getenv('GOOGLE_CLIENT_ID') ?: '991055090704-v6juu3g2bsuj7olv0p135hdk16eu5vsp.apps.googleusercontent.com';
        $verifyUrl = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential);

        // Ưu tiên cURL để tránh bị chặn allow_url_fopen
        $verifyResponse = null;
        if (function_exists('curl_init')) {
            $ch = curl_init($verifyUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            $verifyResponse = curl_exec($ch);
            curl_close($ch);
        }
        if ($verifyResponse === null || $verifyResponse === false) {
            $verifyResponse = @file_get_contents($verifyUrl);
        }

        if ($verifyResponse === false || $verifyResponse === null) {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xác minh tài khoản Google (kiểm tra Internet/https).'
            ]);
            return;
        }

        $tokenData = json_decode($verifyResponse, true);
        if (!is_array($tokenData) || empty($tokenData['email'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Token Google không hợp lệ.',
                'debug' => $verifyResponse
            ]);
            return;
        }

        if (!empty($clientId) && (!isset($tokenData['aud']) || $tokenData['aud'] !== $clientId)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ứng dụng Google không khớp. Vui lòng cấu hình GOOGLE_CLIENT_ID.',
                'debug' => $tokenData
            ]);
            return;
        }

        $email = $tokenData['email'];
        $name = $tokenData['name'] ?? ($tokenData['given_name'] ?? 'Người dùng Google');

        $user = $this->user->getUserByEmail($email);

        if ($user && isset($user['active']) && (int)$user['active'] === 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Tài khoản đã bị khóa, vui lòng liên hệ hỗ trợ.'
            ]);
            return;
        }

        if (!$user) {
            $newUserId = $this->user->insertUserGoogle([
                'email' => $email,
                'name' => $name
            ]);
            $user = $this->user->getUserById($newUserId);
        } else {
            // Nếu trước đó chưa active (đăng ký email), kích hoạt luôn
            if (isset($user['active']) && (int)$user['active'] === 0) {
                $this->user->activateUser($user['id']);
                $user['active'] = 1;
            }
        }

        $_SESSION['user'] = $user['id'];

        echo json_encode([
            'success' => true,
            'message' => 'Đăng nhập bằng Google thành công!',
            'redirect' => ($user['role'] ?? 0) == 1 ? 'admin/index.php' : 'index.php'
        ]);
    }

    /* ========================
       QUÊN MẬT KHẨU
    ======================== */
    function forgotPass()
    {
        if (isset($_POST['quenPass'])) {

            $email = $_POST['forgot-email'];
            $phone = $_POST['forgot-phone'];
            $password = md5($_POST['forgot-password']);
            $repass = md5($_POST['forgot-Repassword']);

              if ($password !== $repass) {
                $_SESSION['cart_message'] = [
                    'text' => 'Mật khẩu không trùng khớp',
                    'type' => 'error'
                ];
                header("Location: index.php");
                exit;
            }

            if ($this->user->checkForgot($email, $phone)) {

                $this->user->updatePass([
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password
                ]);

                 $_SESSION['cart_message'] = [
                    'text' => 'Cập nhật mật khẩu thành công',
                    'type' => 'success'
                ];
                header("Location: index.php");
                exit;
            } else {
                 $_SESSION['cart_message'] = [
                    'text' => 'Email hoặc số điện thoại không đúng',
                    'type' => 'error'
                ];
                header("Location: index.php");
                exit;
            }
        }
    }

    /* ========================
       XÁC THỰC EMAIL
    ======================== */
    function verifyEmail()
    {
        $code = $_GET['code'] ?? '';

        if ($this->user->verify($code)) {

            // Dừng toàn bộ output và redirect chuẩn
            header("Location: index.php?page=login&verified=1");
            exit();
        }

        $_SESSION['cart_message'] = [
            'text' => 'Liên kết xác minh không hợp lệ hoặc đã hết hạn.',
            'type' => 'error'
        ];
         header("Location: index.php");
        exit;
    }

    /* ========================
       INFO + ORDER + ADDRESS
    ======================== */

    function viewUserInfo()
    {
        if (isset($_SESSION['user'])) {
            $idUser = $_SESSION['user'];
            $data['userInfo'] = $this->user->getUserById($idUser);
            return $this->renderView('userInfo', $data);
        }
    }

    function updateUserInfo()
    {
        if (isset($_POST['update-btn'])) {

            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone'])) {
               $_SESSION['cart_message'] = [
                    'text' => 'Vui lòng nhập đầy đủ thông tin',
                    'type' => 'error'
                ];
                header("Location: index.php?page=userInfo");
                exit;
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
               $_SESSION['cart_message'] = [
                    'text' => 'Email không hợp lệ',
                    'type' => 'error'
                ];
                header("Location: index.php?page=userInfo");
                exit;
            }

            if (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
                $_SESSION['cart_message'] = [
                    'text' => 'Số điện thoại phải có 10 chữ số',
                    'type' => 'error'
                ];
                header("Location: index.php?page=userInfo");
                exit;
            }

            $this->user->updateInfo([
                'id' => $_SESSION['user'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ]);

            $_SESSION['cart_message'] = [
                'text' => 'Cập nhật thông tin thành công',
                'type' => 'success'
            ];
            header("Location: index.php?page=userInfo");
            exit;
        }
    }

    function viewUserOrder()
    {
        if (isset($_SESSION['user'])) {
            $idUser = $_SESSION['user'];
            $data['orderList'] = $this->order->getOrderByIdUser($idUser);
            return $this->renderView('userOrder', $data);
        }
    }

    function cancelOrder()
{
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }

    if (isset($_GET['id'])) {
        // GIẢ LẬP POST
        $_POST['order_id'] = (int)$_GET['id'];

        $order = $this->order->getOrderById($_POST['order_id']);
        $_POST['phone'] = $order['receiverPhone'] ?? '';

        $_SERVER['REQUEST_METHOD'] = 'POST';

        require_once 'app/controller/orderController.php';
        (new orderController())->cancelOrder();
        exit;
    }
}



    function viewUserAddress()
    {
        if (isset($_SESSION['user'])) {
            $data['userAddress'] = $this->user->getUserById($_SESSION['user']);
            return $this->renderView('userAddress', $data);
        }
    }

    function deleteAddress()
    {
        if (!isset($_SESSION['user'])) {
                header("Location: index.php");
                exit;
            }

            if (isset($_GET['id'])) {
                $this->user->deleteAddress($_GET['id']);

                $_SESSION['cart_message'] = [
                    'text' => 'Xóa địa chỉ thành công',
                    'type' => 'success'
                ];

                header("Location: index.php?page=userAddress");
                exit;
            }
    }

   function updateAddress()
        {
            if (!isset($_SESSION['user'])) {
                header("Location: index.php");
                exit;
            }
        
            if (isset($_POST['updateAddress'])) {
        
                if (empty($_POST['newAddress'])) {
                    $_SESSION['cart_message'] = [
                        'text' => 'Vui lòng nhập địa chỉ',
                        'type' => 'error'
                    ];
                    header("Location: index.php?page=userAddress");
                    exit;
                }
        
                $this->user->updateAddress(
                    trim($_POST['newAddress']),
                    $_GET['id']
                );
        
                $_SESSION['cart_message'] = [
                    'text' => 'Lưu địa chỉ thành công',
                    'type' => 'success'
                ];
        
                header("Location: index.php?page=userAddress");
                exit;
            }
        }
    public function viewOrderDetail()
    {
    if (!isset($_GET['id'])) {
        $_SESSION['cart_message'] = [
            'text' => 'Đơn hàng không tồn tại',
            'type' => 'error'
        ];
        header("Location: index.php?page=userOrder");
        exit;
    }

    $idOrder = (int)$_GET['id'];
    $idUser = $_SESSION['user'];

    $orderModel = new OrderModel();
    
    // Kiểm tra đơn hàng có thuộc user không
    if (!$orderModel->isOrderBelongToUser($idOrder, $idUser)) {
         $_SESSION['cart_message'] = [
            'text' => 'Đơn hàng không tồn tại',
            'type' => 'error'
        ];
        header("Location: index.php?page=userOrder");
        exit;
    }

    // Lấy chi tiết đơn hàng
    $orderItems = $orderModel->getOrderDetailsWithImages($idOrder);

    if (!$orderItems) {
         $_SESSION['cart_message'] = [
            'text' => 'Đơn hàng không tồn tại',
            'type' => 'error'
        ];
        header("Location: index.php?page=userOrder");
        exit;
    }

    $data['orderItems'] = $orderItems;

    $this->renderView("orderDetail", $data);
}

// Ví dụ logic trong userController.php
public function showPayment() {
    $voucherModel = new VoucherModel();
    $listVoucher = $voucherModel->getAllVouchersActive();

    // Debug thử

    $data['listVoucher'] = $listVoucher;
    include "view/payment.php";
}




}

