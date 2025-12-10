<?php 
class PaymentController{
    private $order;
    private $orderItem;
    function __construct(){
        $this->order = new OrderModel();
        $this->orderItem = new OrderItemModel();
    }

    function renderView($view){
        $view = 'app/view/'.$view.'.php';
        require_once $view;
    }
    function viewPayment(){
        return $this->renderView('payment');
    }
 

    function viewPaymentStep2() {
        if (isset($_POST['payment'])) {
            $totalPrice = $_POST['totalPrice'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $idUser = $_SESSION['user']; // ID của người dùng

    
            // Dữ liệu của đơn hàng
            $item = [
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'totalPrice' => $totalPrice,
                'idUser' => $idUser,
            ];
    
            // Khởi tạo giỏ hàng nếu chưa tồn tại
            if (!isset($_SESSION['order'])) {
                $_SESSION['order'] = [];
            }
    
            // Kiểm tra trùng lặp ID trong giỏ hàng
            $isDuplicate = false;
            foreach ($_SESSION['order'] as $index => $order) {
                if ($order['idUser'] === $idUser) {
                    $_SESSION['order'][$index] = $item;
                    $isDuplicate = true;
                    break;
                }
            }
    
            // Thêm dữ liệu vào session nếu không trùng
            if (!$isDuplicate) {
                $_SESSION['order'][] = $item;
                // echo "Đã thêm dữ liệu vào session.";
            } else {
                // echo "Dữ liệu đã tồn tại, không thêm vào session.";
            }
    
            // Gọi view
            $this->renderView('paymentStep2');
        } else {
            // echo "Chưa thêm được dữ liệu vào session.";
        }
    }

    function createOrder(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitOrder'])) {
        if (isset($_POST['paymentMethod'])) {
            $paymentMethod = $_POST['paymentMethod'];
            $payment = ($paymentMethod === '1') ? 1 : 2;

            if(isset($_SESSION['order']) && isset($_SESSION['cart'])){
                // Lưu đơn hàng vào DB
                $dataOrder = [
                    'totalPrice' => $_SESSION['order'][0]['totalPrice'],
                    'name'       => $_SESSION['order'][0]['name'],
                    'phone'      => $_SESSION['order'][0]['phone'],
                    'idUser'     => $_SESSION['order'][0]['idUser'],
                    'address'    => $_SESSION['order'][0]['address'],
                    'payment'    => $payment
                ];
                $this->order->insertOrder($dataOrder);

                // Lấy id đơn hàng vừa tạo (id tự tăng)
                $orders = $this->order->getOrder();
                $lastOrder = end($orders);
                $orderId = $lastOrder['id'];

                // Lưu chi tiết sản phẩm vào bảng orderdetails
                foreach ($_SESSION['cart'] as $item) {
                    $dataOrderItem = [
                        'idProductDetail' => $item['idProductDetail'],        // phải là id trong bảng productdetail
                        'quantity'        => $item['quantity'],
                        'salePrice'       => $item['price'],
                        'idOrder'         => $orderId,
                        'dateCreate'      => date('Y-m-d H:i:s')
                    ];
                    $this->orderItem->insertOrderItem($dataOrderItem);
                }
            }

            echo "<script>alert('Đặt hàng thành công')</script>";
            echo "<script>location.href='index.php?page=index.php';</script>";
            unset($_SESSION['cart']);
        } else {
            echo "<script>alert('Vui lòng chọn phương thức thanh toán')</script>";
            echo "<script>location.href='index.php?page=payment';</script>";
        }
    }
}

    
    
   
    
    
}