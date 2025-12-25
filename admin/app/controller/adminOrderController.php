<?php
class adminOrderController
{
    private $order;
    // private $orderdetail;
    private $data;
    

    private $logModel;


    
    function __construct()
    {
        $this->order = new OrderModel();
        $this->logModel = new AdminLogModel();
        // $this->orderdetail = new OrderItemModel();
    }

    function renderView($view, $data = null)
{
    $view = './app/view/' . $view . '.php';
    if ($data) {
        extract($data); // biến $ordDetail, $orderStatus, $totalPrice, $idOrder sẽ có sẵn trong view
    }
    require_once $view;
}

    public function viewOrd()
{
    // Lấy trang hiện tại
    $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Lấy trạng thái filter nếu có
    $statusFilter = isset($_GET['status']) ? (int)$_GET['status'] : null;

    if ($statusFilter !== null) {
        // Lấy đơn hàng theo trạng thái
        $this->data['listord'] = $this->order->getOrdersByStatus($statusFilter, $limit, $offset);
        $totalOrders = $this->order->getTotalOrdersByStatus($statusFilter);
    } else {
        // Lấy tất cả đơn hàng
        $this->data['listord'] = $this->order->getOrdersPaginated($limit, $offset);
        $totalOrders = $this->order->getTotalOrders();
    }

    $this->data['totalPages']  = ceil($totalOrders / $limit);
    $this->data['currentPage'] = $page;
    $this->data['statusFilter'] = $statusFilter;

    $this->renderView('order', $this->data);
}


   public function ordDetail()
{
    $idOrder = isset($_GET['id']) ? $_GET['id'] : null;
    if ($idOrder) {
        // Lấy chi tiết sản phẩm trong đơn
        $this->data['ordDetail'] = $this->order->getOrderDetailsWithImages($idOrder);

        // Lấy thông tin đơn hàng
        $orderInfo = $this->order->getOrderById($idOrder);

        // Truyền dữ liệu sang view
        $this->data['orderStatus'] = $orderInfo['orderStatus'];
        $this->data['totalPrice']  = $orderInfo['totalPrice'];
        $this->data['idOrder']     = $idOrder;

        $this->renderView('orderDetail', $this->data);
    } else {
        echo "Không có đơn hàng.";
    }
}

public function submitOrder() {
    if (isset($_POST['submitOrder'])) {
    // 1. Tạo đơn hàng
    $orderId = $this->order->insertOrder([
        'idUser'      => $_SESSION['user']['id'],
        'totalPrice'  => $_POST['totalPrice'],
        'dateOrder'   => date('Y-m-d H:i:s'),
        'orderStatus' => 1
    ]);

    // 2. Lưu chi tiết sản phẩm
    if (!empty($_POST['products'])) {
        foreach ($_POST['products'] as $index => $productId) {
            $quantity = $_POST['quantities'][$index];
            $price    = $_POST['prices'][$index];

            $this->order->insertOrderDetail([
                ':idOrder'         => $orderId,
                ':idProductDetail' => $productId,   // dùng id sản phẩm từ form
                ':quantity'        => $quantity,
                ':salePrice'       => $price,
                ':dateCreate'      => date('Y-m-d H:i:s')
            ]);
        }
    }

    unset($_SESSION['cart']);
    echo "<script>alert('Đặt hàng thành công!')</script>";
    echo "<script>location.href='?page=orderDetail&id={$orderId}'</script>";
}

}



    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $orderId = $_POST['id'] ?? null;
        $status  = $_POST['status'] ?? null;
        $status  = isset($_POST['status']) ? (int)$_POST['status'] : null;
        if ($orderId && isset($status)) {
            // Gọi hàm trong model
            $this->order->updateOrderStatus($orderId, $status);

            // Lấy thông tin trạng thái để ghi log
            $statusText = [
                0 => 'Đã hủy',
                1 => 'Chờ xác nhận',
                2 => 'Đang vận chuyển',
                3 => 'Đã giao'
            ][$status] ?? 'Không xác định';

            $this->logModel->addLog([
                'action'     => 'update',
                'table_name' => 'orders',
                'record_id'  => $orderId,
                'description'=> "Cập nhật trạng thái đơn hàng ID {$orderId} thành: {$statusText}"
            ]);

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Cập nhật trạng thái thành công!'
            ];
            
            header("Location: ?page=orderDetail&id=" . $orderId);
            exit();
        }
    }
}
    public function cancelOrder() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
        $orderId = $_POST['orderId'];
        $order = $this->order->getOrderById($orderId);

        if ($order && $order['status'] == 1) { // chỉ cho hủy khi đang chờ xác nhận
            $this->order->updateOrderStatus($orderId, 0); // 0 = đã hủy
             $_SESSION['cart_message'] = [
                'text' => 'Đã hủy đơn hàng thành công',
                'type' => 'success'
            ];
        } else {
            $_SESSION['cart_message'] = [
                'text' => 'Không thể hủy đơn hàng đã xác nhận hoặc đang xử lý',
                'type' => 'error'
            ];
        }

        header("Location: index.php?page=order");
        exit;
        

          $_SESSION['cart_message'] = [
        'text' => 'Yêu cầu không hợp lệ',
        'type' => 'error'
    ];
    header("Location: index.php?page=order");
    exit;
    }
}


}
