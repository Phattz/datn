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
        if (isset($_POST['dangnhap'])) {

            $email = $_POST['email'];
            $password = md5($_POST['mklogin']);

            $result = $this->user->checkUser($email, $password);

            if (!is_array($result)) {
                echo "<script>alert('Sai email hoặc mật khẩu');location.href='index.php';</script>";
                return;
            }

            // Tài khoản chưa active
            if ($result['active'] == 0) {
                echo "<script>alert('Bạn chưa xác nhận tài khoản. Vui lòng kiểm tra email.');location.href='index.php';</script>";
                return;
            }

            // Tài khoản bị khoá
            if ($result['active'] == 2) {
                echo "<script>alert('Tài khoản đã bị khóa');location.href='index.php';</script>";
                return;
            }

            // Đăng nhập thành công
            $_SESSION['user'] = $result['id'];

            if ($result['role'] == 1) {
                echo "<script>alert('Đăng nhập Admin thành công!');location.href='admin/index.php';</script>";
            } else {
                echo "<script>alert('Đăng nhập thành công!');location.href='index.php';</script>";
            }
        }
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
                echo "<script>alert('Mật khẩu không trùng khớp');location.href='index.php';</script>";
                return;
            }

            if ($this->user->checkForgot($email, $phone)) {

                $this->user->updatePass([
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password
                ]);

                echo "<script>alert('Cập nhật mật khẩu thành công');location.href='index.php';</script>";
            } else {
                echo "<script>alert('Email hoặc số điện thoại không đúng');location.href='index.php';</script>";
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

        echo "<h3 style='color:red;text-align:center;margin-top:40px;'>
                Liên kết xác minh không hợp lệ hoặc đã hết hạn.
              </h3>";
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
                echo "<script>alert('Vui lòng nhập đầy đủ thông tin');location.href='index.php?page=userInfo';</script>";
                return;
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Email không hợp lệ');location.href='index.php?page=userInfo';</script>";
                return;
            }

            if (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
                echo "<script>alert('Số điện thoại phải có 10 chữ số');location.href='index.php?page=userInfo';</script>";
                return;
            }

            $this->user->updateInfo([
                'id' => $_SESSION['user'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ]);

            echo "<script>alert('Cập nhật thành công');location.href='index.php?page=userInfo';</script>";
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
        if (isset($_GET['id'])) {
            $this->order->cancelOrder($_GET['id']);
            echo "<script>alert('Hủy đơn thành công');location.href='index.php?page=userOrder';</script>";
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
        if (isset($_GET['id'])) {
            $this->user->deleteAddress($_GET['id']);
            echo "<script>alert('Xóa địa chỉ thành công');location.href='index.php?page=userAddress';</script>";
        }
    }

    function updateAddress()
    {
        if (isset($_GET['id'])) {
            $this->user->updateAddress($_POST['newAddress'], $_GET['id']);
            echo "<script>alert('Cập nhật địa chỉ thành công');location.href='index.php?page=userAddress';</script>";
        }
    }
}
