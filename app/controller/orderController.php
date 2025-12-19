<?php
class orderController {
    private $order;

    function __construct() {
        require_once 'app/model/orderModel.php';
        $this->order = new OrderModel();
    }

    public function trackOrder()
{   
    // ✅ THÊM ĐOẠN NÀY
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

    if ($orderId === '' || $phone === '') {
        $_SESSION['cart_message'] = [
            'text' => 'Thiếu thông tin hủy đơn',
            'type' => 'error'
        ];
        header("Location: index.php?page=trackOrder");
        exit;
    }

    // LẤY ĐƠN TRƯỚC
    $order = $this->order->getOrderByIdAndPhone($orderId, $phone);

    if (!$order) {
        $_SESSION['cart_message'] = [
            'text' => 'Không tìm thấy đơn hàng',
            'type' => 'error'
        ];
        header("Location: index.php?page=trackOrder");
        exit;
    }

    // ĐƠN ĐÃ HỦY RỒI → KHÔNG BÁO LỖI
    if ($order['orderStatus'] == 0) {
        $_SESSION['cart_message'] = [
            'text' => 'Đơn hàng này đã được hủy trước đó',
            'type' => 'success'
        ];
        header("Location: index.php?page=trackOrder&order_id={$orderId}&phone={$phone}");
        exit;
    }

    // CHỈ HỦY KHI ĐANG CHỜ XÁC NHẬN
    if ($order['orderStatus'] != 1) {
        $_SESSION['cart_message'] = [
            'text' => 'Không thể hủy đơn hàng ở trạng thái hiện tại',
            'type' => 'error'
        ];
        header("Location: index.php?page=trackOrder&order_id={$orderId}&phone={$phone}");
        exit;
    }

    // TIẾN HÀNH HỦY
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
