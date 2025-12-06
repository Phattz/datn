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
        require_once $view;
    }
    function viewOrd()
    {
        $this->data['listord'] = $this->order->getOrder();
        $this->renderView('order', $this->data);
    }

    public function OrdDetail()
    {
        $idOrder = isset($_GET['id']) ? $_GET['id'] : null;
        if ($idOrder) {
            $this->data['ordDetail'] = $this->order->getOrderDetailsWithImages($idOrder);
            $this->data['orderStatus'] = $this->order->getOrderStatus($idOrder);
            $this->data['idOrder'] = $idOrder;
            $this->renderView('orderDetail', $this->data);
        } else {
            echo "Không có đơn hàng.";
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $orderId = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;
            if ($orderId && isset($status)) {
                $this->order->updateOrderStatus($orderId, $status);
                
                // Lấy thông tin đơn hàng để ghi log
                $orderInfo = $this->order->getOrderStatus($orderId);
                $statusText = ['Đã hủy', 'Chờ xử lý', 'Đang giao', 'Hoàn thành'][$status] ?? 'Không xác định';
                
                // Ghi log
                $this->logModel->addLog([
                    'action' => 'update',
                    'table_name' => 'orders',
                    'record_id' => $orderId,
                    'description' => "Cập nhật trạng thái đơn hàng ID {$orderId} thành: {$statusText}"
                ]);
                
                echo '<script>alert("Đã cập nhật trạng thái đơn hàng thành công")</script>';
                echo '<script>location.href="?page=order"</script>';
            }
        }
    }
}
