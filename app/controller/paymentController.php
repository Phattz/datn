<?php 
class PaymentController{
    private $order;
    private $orderItem;
    function __construct(){
        $this->order = new OrderModel();
        $this->orderItem = new OrderItemModel();
    }

    function renderView($view, $data = []) {
        extract($data);
        require_once 'app/view/'.$view.'.php';
    }
    function viewPayment(){

        $data = [];

        // Nếu user đã đăng nhập → lấy thông tin user
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];

            require_once 'app/model/userModel.php';
            $userModel = new UserModel();

            $userInfo = $userModel->getUserById($userId);
            $data['userInfo'] = $userInfo;
        }

        return $this->renderView('payment', $data);
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
    
            if (!isset($_POST['paymentMethod'])) {
                echo "<script>alert('Vui lòng chọn phương thức thanh toán')</script>";
                echo "<script>location.href='index.php?page=payment';</script>";
                exit;
            }
    
            if (!isset($_SESSION['order']) || !isset($_SESSION['cart'])) {
                echo "<script>alert('Không có thông tin đơn hàng');</script>";
                echo "<script>location.href='index.php?page=cart';</script>";
                exit;
            }
    
            $paymentMethod = $_POST['paymentMethod'];
            $paymentMethod = intval($paymentMethod);
    
            // LẤY DỮ LIỆU TỪ SESSION ORDER
            $orderSession = $_SESSION['order'][0];
    
            $dataOrder = [
                "shippingAddress" => $orderSession['address'],
                "idVoucher"       => null,
                "receiverPhone"   => $orderSession['phone'],
                "receiverName"    => $orderSession['name'],
                "idPayment"       => $paymentMethod,
                "totalPrice"      => $orderSession['totalPrice'],
                "dateOrder"       => date("Y-m-d H:i:s"),
                "orderStatus"     => 1, // pending
                "idUser"          => $orderSession['idUser']
            ];
            
            // TẠO ĐƠN HÀNG → TRẢ VỀ orderId
            $orderId = $this->order->insertOrder($dataOrder);
    
            // LƯU CHI TIẾT ĐƠN HÀNG
            foreach ($_SESSION['cart'] as $item) {

                $dataOrderItem = [
                    "idOrder"         => $orderId,
                    "idProductDetail" => $item['idProductDetail'],
                    "quantity"        => $item['quantity'],
                    "salePrice"       => $item['price']  // GIÁ TỪ GIỎ HÀNG
                ];
            
                $this->orderItem->insertOrderItem($dataOrderItem);
            }
            
    
            // XOÁ GIỎ HÀNG
            unset($_SESSION['cart']);
            unset($_SESSION['order']);
    
            echo "<script>alert('Đặt hàng thành công')</script>";
            echo "<script>location.href='index.php?page=index.php';</script>";
        }
    }
    
    }
 