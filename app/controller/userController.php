<?php
class UserController
{
    private $user;
    private $mailController;
    private $data;
    private $order;
    private $favorite;

    function __construct()
    {
        $this->user = new UserModel();
        $this->mailController = new MailerController();
        $this->order = new OrderModel();
        $this->favorite = new FavoriteModel();
    }

    function renderView($view, $data){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }
    public function register()
    {
        if (isset($_POST['dangky'])) {
            $data = [];
            $data['email'] = $_POST['re-email'];
            $pasword = $_POST['mk'];
            $repass = $_POST['remk'];
            $data['name'] = $_POST['hoten'];
            $data['phone'] = $_POST['sdt'];

            if ($pasword === $repass) {
                $result = $this->user->checkmail($data['email']);
                if ($result) {
                    echo "<script>
                   alert('Email đã tồn tại');
               </script>";

                    echo "<script>
                   location.href='index.php';
               </script>";
                } else {
                    $data['password'] = md5($pasword);
                    $verificationCode = bin2hex(random_bytes(32));
                    $this->user->insertUser($data, $verificationCode);
                    $this->mailController->sendVerificationEmail($data['email'], $verificationCode);
                    echo "<script>
                   alert('Đăng ký thành công');
               </script>";

                    echo "<script>
                   location.href='index.php';
               </script>";
                }
            } else {
                echo "<script>
                   alert('Mật khẩu không trùng khớp ');
               </script>";

                echo "<script>
                   location.href='index.php';
               </script>";
            }
        }
    }

    public function login()
    {
        if (isset($_POST['dangnhap'])) {
            $email = $_POST['email'];
            $password = md5($_POST['mklogin']);
            $result = $this->user->checkUser($email, $password);
            $_SESSION['user'] = $result['id'];
            if (is_array($result)) {
                if ($result['role'] == 1 && $result['active'] == 1) {
                    // $_SESSION['admin'] = $result['username'];
                    echo "<script>
                    alert('Đăng nhập admin thành công');
                </script>";
                    echo "<script>
                    location.href='admin/index.php';
                </script>";
                } else if ($result['role'] == 0 && $result['active'] == 1) {
                    $_SESSION['user'] = $result['id'];
                    $userId = $result['id'];
                    echo "<script>
                    localStorage.setItem('userId', '$userId');
                    alert('Đăng nhập thành công');
                </script>";
                    echo "<script>
                    location.href='index.php';
                </script>";
                } else if ($result['role'] == 0 && $result['active'] == 0) {
                    echo "<script>
                    alert('Bạn chưa xác nhận tài khoản qua Email, vui lòng xác nhận!');
                </script>";
                    echo "<script>
                    location.href='index.php';
                </script>";
                session_unset();
                } else if ($result['role'] == 0 && $result['active'] == 2) {
                    echo "<script>
                    alert('Tài khoản của bạn đã bị khóa (X)');
                </script>";
                    echo "<script>
                    location.href='index.php';
                </script>";
                session_unset();
                } else {
                    echo "<script>
                    alert('Tài khoản không tồn tại, vui lòng đăng ký tài khoản mới');
                </script>";
                    echo "<script>
                    location.href='index.php';
                </script>";
                }
            } else {
                echo "<script>
                alert('Sai email hoặc mật khẩu, vui lòng nhập lại');
            </script>";
                echo "<script>
                location.href='index.php';
            </script>";
            }
        }
    }

    function forgotPass()
    {
        if (isset($_POST['quenPass'])) {
            $data = [];
            $data['email'] = $_POST['forgot-email'];
            $data['password'] = md5($_POST['forgot-password']);
            $repass = md5($_POST['forgot-Repassword']);
            $data['phone'] = $_POST['forgot-phone'];
            if ($data['password'] == $repass && $this->user->checkForgot($data['email'], $data['phone'])) {
                $this->user->updatePass($data);
                echo '<script>alert("Cập nhật thành công")</script>';
                echo '<script>location.href="index.php"</script>';
            } else {
                echo '<script>alert("Chưa cập nhật được mật khẩu. Hãy kiểm tra lại email, số điện thoại hoặc mật khẩu")</script>';
                echo '<script>location.href="index.php"</script>';
            }

        }
    }

    function verifyEmail()
    {
        $code = $_GET['code'] ?? '';
        if ($this->user->verify($code)) {
            echo "<script>alert('Xác thực thành công! Vui lòng đăng nhập để sử dụng dịch vụ của chúng tôi.')</script>";
            echo '<script>location.href="index.php"</script>';
        } else {
            echo "Liên kết xác minh không hợp lệ hoặc đã hết hạn.";
        }
    }
    //trang thông tin người dùng
    function viewUserInfo(){
        if(isset($_SESSION['user'])){
            $idUser = $_SESSION['user'];
            $this->data['userInfo'] = $this->user->getUserById($idUser);
        }
        return $this->renderView('userInfo', $this->data);
    }

    function updateUserInfo(){
        if(isset($_POST['update-btn'])){
           // Kiểm tra các trường không được rỗng
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone'])) {
            echo '<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
            echo '<script>location.href="index.php?page=userInfo"</script>';
            return;
        }

        // Kiểm tra email hợp lệ
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Email không hợp lệ!")</script>';
            echo '<script>location.href="index.php?page=userInfo"</script>';
            return;
        }

        // Kiểm tra số điện thoại hợp lệ
        if (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
            echo '<script>alert("Số điện thoại phải có 10 chữ số!")</script>';
            echo '<script>location.href="index.php?page=userInfo"</script>';
            return;
        }
            $data = [];
            $data['id'] = $_SESSION['user'];
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['phone'] = $_POST['phone'];
            $this->user->updateInfo($data);
            echo '<script>alert("Cập nhật thành công")</script>';
            echo '<script>location.href="index.php?page=userInfo"</script>';

        }
    }
    //trang đơn hàng người dùng
    function viewUserOrder(){
        if(isset($_SESSION['user'])){
            $idUser = $_SESSION['user'];
            $this->data['orderList'] = $this->order->getOrderByIdUser($idUser);
        }
        return $this->renderView('userOrder', $this->data);
    }

    function cancelOrder(){
        if(isset($_GET['id'])){
            $idOrder = $_GET['id'];
            $this->order->cancelOrder($idOrder);
            echo '<script>alert("Hủy đơn hàng thành công!")</script>';
            echo '<script>location.href="index.php?page=userOrder"</script>';
        }
    }
    //trang yêu thích của người dùng
    function viewUserFavorite(){
        if(isset($_SESSION['user'])){
            $idUser = $_SESSION['user'];
            $this->data['favorite'] = $this->favorite->getAllFavoriteByIdUser($idUser);
        }
        return $this->renderView('userFavorite',$this->data);
    }
    //trang địa chỉ của người dùng
    function viewUserAddress(){
        if(isset($_SESSION['user'])){
            $idUser = $_SESSION['user'];
            $this->data['userAddress'] = $this->user->getUserById($idUser);
        }
        return $this->renderView('userAddress', $this->data);
    }

    function deleteAddress(){
        if(isset($_GET['id'])){
            $idUser = $_GET['id'];
            $this->user->deleteAddress($idUser);
            echo '<script>alert("Xóa địa chỉ thành công!")</script>';
            echo '<script>location.href="index.php?page=userAddress"</script>';
        }
    }

    function updateAddress(){
        if(isset($_GET['id'])){
            $idUser = $_GET['id'];
            $data = $_POST['newAddress'];
            $this->user->updateAddress($data, $idUser);
            echo '<script>alert("Cập nhật địa chỉ mới thành công!")</script>';
            echo '<script>location.href="index.php?page=userAddress"</script>';
        }
    }

    




}