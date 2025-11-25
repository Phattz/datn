<?php
class adminOrderController
{
    private $order;
    // private $orderdetail;
    private $data;

    function __construct()
    {
        $this->order = new OrderModel();
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
                echo '<script>alert("Đã sửa danh mục thành công")</script>';
                echo '<script>location.href="?page=order"</script>';
            }
        }
    }
}
