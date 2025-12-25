<?php
session_start();
// Kiểm tra đăng nhập admin (tạm thời comment, sẽ thêm sau)
// if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] != 1) {
//     header('Location: ../index.php');
//     exit;
// }
require_once '../app/model/colorModel.php';
require_once '../app/model/voucherModel.php';
require_once '../app/model/database.php';
require_once '../app/model/productCateModel.php';
require_once '../app/model/productsModel.php';
require_once '../app/model/userModel.php';
require_once '../app/model/productCommentModel.php';
require_once '../app/model/orderModel.php';
require_once '../app/model/bannerModel.php';
require_once '../app/model/postModel.php';
require_once '../app/model/postCateModel.php';
require_once '../app/model/adminLogModel.php';
require_once '../app/model/reviewModel.php';

require_once 'app/controller/adminDashboardController.php';
require_once 'app/controller/adminCateController.php';
require_once 'app/controller/adminProController.php';
require_once 'app/controller/adminUserController.php';
require_once 'app/controller/adminCommentController.php';
require_once 'app/controller/adminOrderController.php';
require_once 'app/controller/adminBannerController.php';
require_once 'app/controller/adminColorController.php';
require_once 'app/controller/adminLogController.php';
require_once 'app/controller/adminPostController.php';
require_once 'app/controller/adminReviewController.php';
require_once 'app/controller/voucherController.php';
require_once 'app/view/menu.php';
$db = new Database();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        // Dashboard
        case 'dashboard':
        case '':
            $dashboard = new AdminDashboardController();
            $dashboard->viewDashboard();
            break;
         case 'hideProduct':
        include 'app/view/hideProduct.php';
        break;
    
        //category
        
        case 'category':
            $category = new CateAdminController();
            $category->viewCategory();
            break;
        case 'editcate':
            $editcate = new CateAdminController();
            $editcate->viewEditCate();
            break;
        case 'updatecate':
            $updatecate = new CateAdminController();
            $updatecate->updateCate();
            break;
        case 'viewaddcate':
            $viewaddcate = new CateAdminController();
            $viewaddcate->viewAddCate();
            break;
        case 'addcate':
            $addcate = new CateAdminController();
            $addcate->addCate();
            break;
            //product
        case 'product':
            $product = new ProAdminController();
            $product->viewPro();
            break;
        case 'editpro':
            $editpro = new ProAdminController();
            $editpro->viewEditPro();
            break;
        case 'updatepro':
            $updatepro = new ProAdminController();
            $updatepro->updatePro();
            break;
        case 'viewaddpro':
            $addpro = new ProAdminController();
            $addpro->viewAdd();
            break;
        case 'addpro':
            $addpro = new ProAdminController();
            $addpro->addPro();
            break;
        case 'user':
            $user = new UserController();
            $user->viewUser();
            break;
        case 'addUser':
            $addUser = new UserController();
            $addUser->addUser();
            break;
        case 'viewEditUser':
            $viewEditUser = new UserController();
            $viewEditUser->ViewEditUser();
            break;
        case 'editUser':
            $editUser = new UserController();
            $editUser->editUser();
            break;
        case 'deleteuser':
            $deleteuser = new UserController();
            $deleteuser->delUser();
            break;
        case 'adminSearchUser':
            $adminSearchUser = new UserController();
            $adminSearchUser->adminSearchUser();
            break;
            //order
        case 'order':
            $order = new adminOrderController();
            $order->viewOrd();
            break;
        case 'orderDetail':
            $orderDetail = new adminOrderController();
            $orderDetail->OrdDetail();
            break;
        case 'updateStatus':
            $updateStatus = new adminOrderController();
            $updateStatus->updateStatus();
            break;
    
            //comment
        case 'comment':
            $comment = new CommentAdminController();
            $comment->viewCmt();
            break;
        case 'commentDetail':
            $commentdetail = new CommentAdminController();
            $commentdetail->CmtDetail();
            break;
            
        // Banner
        case 'banner':
            $banner = new AdminBannerController();
            $banner->viewBanner();
            break;
        case 'viewaddbanner':
            $banner = new AdminBannerController();
            $banner->viewAddBanner();
            break;
        case 'addbanner':
            $banner = new AdminBannerController();
            $banner->addBanner();
            break;
        case 'editbanner':
            $banner = new AdminBannerController();
            $banner->viewEditBanner();
            break;
        case 'updatebanner':
            $banner = new AdminBannerController();
            $banner->updateBanner();
            break;
        case 'deletebanner':
            $banner = new AdminBannerController();
            $banner->delBanner();
            break;
            
        // Color
        case 'color':
            $color = new AdminColorController();
            $color->viewColor();
            break;
        case 'viewaddcolor':
            $color = new AdminColorController();
            $color->viewAddColor();
            break;
        case 'addcolor':
            $color = new AdminColorController();
            $color->addColor();
            break;
        case 'editcolor':
            $color = new AdminColorController();
            $color->viewEditColor();
            break;
        case 'updatecolor':
            $color = new AdminColorController();
            $color->updateColor();
            break;
            
        // Log/Database
        case 'log':
            $log = new AdminLogController();
            $log->viewLogs();
            break;
            
        default:
            $dashboard = new AdminDashboardController();
            $dashboard->viewDashboard();
            break;
        //post
        case 'post':
            $post = new PostAdminController();
            $post->view();
            break;
        case 'addPost':
            $addPost = new PostAdminController();
            $addPost->addPost();
            break;
        case 'viewEditPost':
            $viewEditPost = new PostAdminController();
            $viewEditPost->viewEditPost();
            break;
        case 'editPost':
            $editPost = new PostAdminController();
            $editPost->editPost();
            break;
        case 'deletepost':
            $deletepost = new PostAdminController();
            $deletepost->delPost();
            break;
        case 'adminSearchPost':
            $adminSearchPost = new PostAdminController();
            $adminSearchPost->adminSearchPost();
            break;
                // review
        case 'review':
            $review = new ReviewAdminController();
            $review->viewReview();
            break;

        case 'reviewDetail':
            $review = new ReviewAdminController();
            $review->reviewDetail();
            break;
        case 'voucher':
            $controller = new VoucherController();
            $controller->viewVoucher();
            break;
    }
} else {
    $dashboard = new AdminDashboardController();
    $dashboard->viewDashboard();
}

?><style>
    #toast-msg-fixed {
        position: fixed;
        top: 150px;
        left: 50%;
        transform: translateX(-50%);
        padding: 14px 26px;
        border-radius: 8px;
        font-size: 16px;
        color: #fff;
        z-index: 99999;
        transition: opacity .4s ease;
    }
    #toast-msg-fixed.success { background:#4CAF50; }
    #toast-msg-fixed.error { background:#E53935; }
    #toast-msg-fixed.hide { opacity:0; }
</style>

<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
        <?= $_SESSION['cart_message']['text']; ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("toast-msg-fixed");
    if (el) {
        setTimeout(() => el.classList.add("hide"), 1600);
        setTimeout(() => el.remove(), 2000);
    }
});
</script>
