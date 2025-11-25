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
            $noteUser = $_POST['noteUser'];
            $idUser = $_SESSION['user']; // ID của người dùng

    
            // Dữ liệu của đơn hàng
            $item = [
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'totalPrice' => $totalPrice,
                'noteUser' => $noteUser,
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
                $orderId = count($this->order->getIdOrder())+1;

                $paymentMethod = $_POST['paymentMethod'];
        
                if ($paymentMethod === '1') {
                    $payment = 1;
                    //thêm vào bảng orders
                    if(isset($_SESSION['order']) && isset($_SESSION['cart'])){
                        // Lưu dữ liệu đơn hàng vào db
                        $dataOrder = [
                            'totalPrice' => $_SESSION['order'][0]['totalPrice'],
                            'noteUser' => $_SESSION['order'][0]['noteUser'],
                            'name' => $_SESSION['order'][0]['name'],
                            'phone' => $_SESSION['order'][0]['phone'],
                            'idUser' => $_SESSION['order'][0]['idUser'],
                            'address' => $_SESSION['order'][0]['address'],
                            'payment' => $payment,
                            'id' => $orderId
                        ];
                        $this->order->insertOrder($dataOrder);
                    }
                    //thêm vào bảng orderitems
                    if(isset($_SESSION['order']) && isset($_SESSION['cart'])){
                        foreach ($_SESSION['cart'] as $item) {
                            $dataOrderItem = [
                                'idProduct' => $item['id'],
                                'quantity' => $item['quantity'],
                                'priceItem' => $item['price'],
                                'idOrder' => $orderId,
                            ];
                            $this->orderItem->insertOrderItem($dataOrderItem);
                        }
                    }
                } elseif ($paymentMethod === '2') {
                    $payment = 2;
                    if(isset($_SESSION['order']) && isset($_SESSION['cart'])){
                        // Lưu dữ liệu đơn hàng vào db
                        $dataOrder = [
                            'totalPrice' => $_SESSION['order'][0]['totalPrice'],
                            'noteUser' => $_SESSION['order'][0]['noteUser'],
                            'name' => $_SESSION['order'][0]['name'],
                            'phone' => $_SESSION['order'][0]['phone'],
                            'idUser' => $_SESSION['order'][0]['idUser'],
                            'address' => $_SESSION['order'][0]['address'],
                            'payment' => $payment,
                            'id' => $orderId
                        ];
                        $this->order->insertOrder($dataOrder);
                    }
                    //thêm vào bảng orderitems
                    if(isset($_SESSION['order']) && isset($_SESSION['cart'])){
                        foreach ($_SESSION['cart'] as $item) {
                            $dataOrderItem = [
                                'idProduct' => $item['id'],
                                'quantity' => $item['quantity'],
                                'priceItem' => $item['price'],
                                'idOrder' => $orderId,
                            ];
                            $this->orderItem->insertOrderItem($dataOrderItem);
                        }
                    }
                    
                }
                echo "<script>alert('Đặt hàng thành công')</script>";
                echo "<script>location.href='index.php?page=index.php';</script>";
                unset($_SESSION['cart']);
            } else {
                echo "<script>alert('Vui lòng chọn phương thức thanh toán')</script>";
                echo "<script>
                location.href='index.php?page=payment';
            </script>";
            }
        }
        
    }
    
    
   
    
    
}