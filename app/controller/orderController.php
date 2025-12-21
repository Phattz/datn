<?php
class orderController {
    private $order;
    private $orderItem;
    private $productModel;
    function __construct() {
        require_once 'app/model/orderModel.php';
        require_once 'app/model/orderItemModel.php';
        require_once 'app/model/productsModel.php';

        $this->order        = new OrderModel();
        $this->orderItem    = new OrderItemModel();
        $this->productModel = new ProductsModel();
    }

    public function trackOrder()
{   

    if ($_SERVER['REQUEST_METHOD'] === 'GET'
        && isset($_GET['order_id'], $_GET['phone'])) {

        $orderId = trim($_GET['order_id']);
        $phone   = trim($_GET['phone']);

        $order = $this->order->getOrderByIdAndPhone($orderId, $phone);

        if ($order) {
            require_once 'app/view/trackOrderResult.php';
            return;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderId = trim($_POST['order_id'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');

        if ($orderId === '' || $phone === '') {
            $_SESSION['cart_message'] = [
                'text' => 'Vui lòng nhập mã đơn hàng và số điện thoại',
                'type' => 'error'
            ];
            header("Location: index.php?page=trackOrder");
            exit;
        }

        $order = $this->order->getOrderByIdAndPhone($orderId, $phone);

        if (!$order) {
            $_SESSION['cart_message'] = [
                'text' => 'Không tìm thấy đơn hàng',
                'type' => 'error'
            ];
            header("Location: index.php?page=trackOrder");
            exit;
        }

        require_once 'app/view/trackOrderResult.php';
        return;
    }

    require_once 'app/view/trackOrder.php';
}
public function cancelOrder()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php");
        exit;
    }

    $orderId = trim($_POST['order_id'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');

    $order = $this->order->getOrderByIdAndPhone($orderId, $phone);
    if (!$order || (int)$order['orderStatus'] !== 1) {
        header("Location: index.php?page=trackOrder");
        exit;
    }

    $orderItems = $this->order->getOrderDetailsWithImages($orderId);

    foreach ($orderItems as $item) {
        $this->productModel->increaseStock(
            (int)$item['idProductDetail'],
            (int)$item['quantity']
        );
    }

    $this->order->cancelOrderByIdAndPhone($orderId, $phone);

    $_SESSION['cart_message'] = [
        'text' => 'Đã hủy đơn hàng thành công',
        'type' => 'success'
    ];

    header("Location: index.php?page=trackOrder&order_id={$orderId}&phone={$phone}");
    exit;
}


public function trackOrderDetail()
{
    $orderId = trim($_GET['order_id'] ?? '');
    $phone   = trim($_GET['phone'] ?? '');

    if ($orderId === '' || $phone === '') {
        header("Location: index.php?page=trackOrder");
        exit;
    }

    // 1. Kiểm tra đơn hàng (bảo mật)
    $order = $this->order->getOrderByIdAndPhone($orderId, $phone);
    if (!$order) {
        $_SESSION['cart_message'] = [
            'text' => 'Không tìm thấy đơn hàng',
            'type' => 'error'
        ];
        header("Location: index.php?page=trackOrder");
        exit;
    }

    // 2. LẤY CHI TIẾT ĐƠN – DÙNG HÀM BẠN GỬI
    $orderDetails = $this->order->getOrderDetailsWithImages($orderId);

    require_once 'app/view/trackOrderDetail.php';
}


}
