
<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Ho_Chi_Minh');
// session_unset();
//Model
require_once 'vendor/autoload.php';
require_once 'app/model/database.php';
require_once 'app/model/productsModel.php';
require_once 'app/model/userModel.php';
require_once 'app/model/productCateModel.php';
require_once 'app/model/productCommentModel.php';

require_once 'app/model/ratingModel.php';
require_once 'app/model/searchModel.php';
require_once 'app/model/orderModel.php';
require_once 'app/model/orderItemModel.php';
require_once 'app/model/bannerModel.php';
require_once 'app/model/mailModel.php';
require_once 'app/model/voucherModel.php';

//Controller
require_once 'app/controller/homeController.php';
require_once 'app/controller/paymentController.php';
require_once 'app/controller/userController.php';
require_once 'app/controller/productController.php';

require_once 'app/controller/mailerController.php';
require_once 'app/controller/cartController.php';
require_once 'app/controller/searchController.php';
require_once 'app/controller/contactController.php';

$page = $_GET['page'] ?? null;
$ctrl = $_GET['ctrl'] ?? null;

// Xử lý đăng nhập/đăng ký Google bằng Ajax, tránh render header/footer
if ($page === 'googleLogin') {
    $googleAuth = new UserController();
    $googleAuth->googleLogin();
    exit;
}

require_once 'app/view/header.php';
// tang giam so luong 
$act  = $_GET['act'] ?? null;

if ($ctrl == 'cart') {
    $cart = new CartController();
    if ($act == 'increase') {
        $cart->increase($_GET['proId'], $_GET['color']);
    } elseif ($act == 'decrease') {
        $cart->decrease($_GET['proId'], $_GET['color']);
    } elseif ($act == 'viewCart') {
        $cart->viewCart();
    }
}


$db = new DataBase();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'home':
            $home = new HomeController();
            $home->viewHome();
            break;

        // trang sản phẩm
        case 'product':
            $product = new ProductController();
            $product->viewProCate();
            break;
        case 'productDetail':
            $productDetail = new ProductController();
            $productDetail->viewProDetail();
            break;
        case 'getPrice':
            $ctrl->getPrice();
            break;
        
        
            
        // Bình Luận
        case 'addComment':
            $addComment = new ProductController();
            $addComment->addComment();
            break;
        

            // giỏ hàng
        case 'boxCart':
            $cart = new CartController();
            $cart->viewCart();
            break;


        // trang thanh toán
        case 'payment':
            $payment = new PaymentController();
            $payment->viewPayment();
            break;
        // case 'paymentStep1':
        //     $paymentStep2 = new PaymentController();
        //     $paymentStep2->viewPaymentStep1();
        //     break;
        case 'paymentStep2':
            $paymentStep2 = new PaymentController();
            $paymentStep2->viewPaymentStep2();
            break;

            // trang thông tin người dùng
        case 'userInfo':
            $userInfo = new UserController();
            $userInfo->viewUserInfo();
            break;
        case 'updateInfo':
            $updateInfo = new UserController();
            $updateInfo->updateUserInfo();
            break;
            //trang đơn hàng người dùng
        case 'userOrder':
            $userOrder = new UserController();
            $userOrder->viewUserOrder();
            break;
        case 'cancelOrder':
            $cancelOrder = new UserController();
            $cancelOrder->cancelOrder();
            break;
            //trang địa chỉ người dùng
        case 'userAddress':
            $userAddress = new UserController();
            $userAddress->viewUserAddress();
            break;
        case 'deleteAddress':
            $deleteAddress = new UserController();
            $deleteAddress->deleteAddress();
            break;
        case 'updateAddress':
            $updateAddress = new UserController();
            $updateAddress->updateAddress();
            break;

        case 'orderDetail':
            $userController = new UserController();
            $userController->viewOrderDetail();
            break;
            
        
        

            //trang liên hệ
        case 'contact':
            $contact = new ContactController();
            $contact->viewContact();
            break;
           //gửi mail liên hệ
        case 'contactSendMail':
            $contactSendMail = new ContactController();
            $contactSendMail->handleContactForm();
            //trang giới thiệu
      
        //các chức năng
        case 'register':
            $register = new UserController();
            $register->register();
            break;
        case 'login':
            $login = new UserController();
            $login->login();
            break;
        case 'logout':
            session_unset();
            echo "<script>
                    if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
                        // Người dùng chọn Yes
                        localStorage.removeItem('userId');
                        localStorage.removeItem('danhSachThichSP');
                        alert('Đăng xuất thành công');
                        window.location.href = 'index.php'; 
                    } else {
                        // Người dùng chọn No
                        alert('Bạn đã hủy đăng xuất');
                        window.history.back(); // Quay lại trang trước
                    }
                </script>";
            break;
        case 'forgotPass':
            $forgotPass = new UserController();
            $forgotPass->forgotPass();
            break;
        //giỏ hàng
        case 'addToCart':
            $addToCart = new CartController();
            $addToCart->addToCart();
            break;
        case 'checkQuantity':
            $checkQuantity = new CartController();
            $checkQuantity->checkQuantity();
            break;
        case 'removeFromCart':
            $removeFromCart = new CartController();
            $removeFromCart->removeFromCart();
            break;
        case 'addToCartInDetail':
            $addToCartInDetail = new CartController();
            $addToCartInDetail->addToCartInDetail();
            break;
        case 'updateCart':
            $updateCart = new CartController();
            $updateCart->updateCart();
            break;
        //tìm kiếm
        case 'search':
            $search = new SearchController();
            $search->getSearch();
            break;
        //đặt hàng
        case 'order':
            $order = new PaymentController();
            $order->createOrder();
            break;


        //xác thực email
        case 'verify':
            $verify = new UserController();
            $verify->verifyEmail();
            break;
        



        default:
            $home = new HomeController();
            $home->viewHome();
            break;
    }
} else {
    $home = new HomeController();
    $home->viewHome();
}
require_once 'app/view/footer.php';