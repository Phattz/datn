<?php
require_once '../app/model/database.php';
require_once '../app/model/productCateModel.php';
require_once '../app/model/productsModel.php';
require_once '../app/model/postCateModel.php';
require_once '../app/model/postModel.php';
require_once '../app/model/userModel.php';
require_once '../app/model/productCommentModel.php';
require_once '../app/model/orderModel.php';

require_once 'app/controller/adminCateController.php';
require_once 'app/controller/adminProController.php';
require_once 'app/controller/adminPostCateController.php';
require_once 'app/controller/adminPostController.php';
require_once 'app/controller/adminUserController.php';
require_once 'app/controller/adminCommentController.php';
require_once 'app/controller/adminOrderController.php';
require_once 'app/view/menu.php';
$db = new Database();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
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
        case 'deletecate':
            $deletecate = new CateAdminController();
            $deletecate->delCate();
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
        case 'deletepro':
            $deletepro = new ProAdminController();
            $deletepro->delPro();
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
            //user
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
        default:
            $category = new CateAdminController();
            $category->viewCategory();
            break;
    }
} else {
    $category = new CateAdminController();
    $category->viewCategory();
}
