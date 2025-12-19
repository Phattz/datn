<?php 
class PaymentController{
    private $order;
    private $orderItem;
    private $productModel;
    
    // 1. CẤU HÌNH VNPAY SANDBOX
    private $vnp_TmnCode = "CGXZLS0Z"; 
    private $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; 
    private $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    private $vnp_Returnurl = "http://localhost/datn/index.php?page=vnpay_return"; // Đảm bảo URL này đúng với Router

    function __construct(){
        $this->order = new OrderModel();
        $this->orderItem = new OrderItemModel();
        $this->productModel = new ProductsModel();
    }

    function renderView($view, $data = []) {
        extract($data);
        require_once 'app/view/'.$view.'.php';
    }

    function viewPayment(){
        $data = [];
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
        if (empty($_SESSION['user'])) {
           $_SESSION['cart_message'] = [
                'text' => 'Vui lòng đăng nhập trước khi thanh toán',
                'type' => 'error'
            ];
            header("Location: index.php");
            exit;
        }
        if (isset($_POST['payment'])) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $idUser = $_SESSION['user'];
            $voucherCode = isset($_POST['voucher_code']) ? trim($_POST['voucher_code']) : '';

            // TÍNH TOÁN TIỀN
            $productTotal = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $productTotal += $item['price'] * $item['quantity'];
                }
            }

            $shippingFee = 30000;
            $discountOrder = 0;
            $discountShipping = 0;
            $idVoucher = null;

            if ($voucherCode !== '') {
                require_once 'app/model/voucherModel.php';
                $voucherModel = new VoucherModel();
                $voucher = $voucherModel->getActiveByCode($voucherCode);

                if (!$voucher) {
                     $_SESSION['cart_message'] = [
                        'text' => 'Voucher không hợp lệ hoặc đã hết hạn',
                        'type' => 'error'
                    ];
                    header("Location: index.php?page=payment");
                    exit;
                }

                $value = $voucherModel->extractValue($voucher);
                $applyType = $voucher['applyType'];
                $discountType = $voucher['discountType'];

                if ($discountType === 'percent') {
                    $percent = min($value, 100);
                    if ($applyType === 'order') {
                        $discountOrder = round($productTotal * $percent / 100);
                    } elseif ($applyType === 'shipping') {
                        $discountShipping = round($shippingFee * $percent / 100);
                    }
                } elseif ($discountType === 'fixed') {
                    if ($applyType === 'order') {
                        $discountOrder = min($value, $productTotal);
                    } elseif ($applyType === 'shipping') {
                        $discountShipping = min($value, $shippingFee);
                    }
                }
                $idVoucher = $voucher['id'];
            }

            $grandTotal = max(0, $productTotal + $shippingFee - $discountOrder - $discountShipping);

            $item = [
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'productTotal' => $productTotal,
                'shippingFee' => $shippingFee,
                'discountOrder' => $discountOrder,
                'discountShipping' => $discountShipping,
                'totalPrice' => $grandTotal,
                'idVoucher' => $idVoucher,
                'voucherCode' => $voucherCode,
                'idUser' => $idUser,
            ];
    
            if (!isset($_SESSION['order'])) { $_SESSION['order'] = []; }
    
            $isDuplicate = false;
            foreach ($_SESSION['order'] as $index => $order) {
                if ($order['idUser'] === $idUser) {
                    $_SESSION['order'][$index] = $item;
                    $isDuplicate = true;
                    break;
                }
            }
            if (!$isDuplicate) { $_SESSION['order'][] = $item; }
    
            $this->renderView('paymentStep2');
        } 
    }

    function createOrder(){
        if (empty($_SESSION['user'])) {
             $_SESSION['cart_message'] = [
                'text' => 'Vui lòng đăng nhập trước khi đặt hàng',
                'type' => 'error'
            ];
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitOrder'])) {
    
            if (!isset($_POST['paymentMethod'])) {
                $_SESSION['cart_message'] = [
                    'text' => 'Vui lòng chọn phương thức thanh toán',
                    'type' => 'error'
                ];
                header("Location: index.php?page=payment");
                exit;
            }
    
            if (!isset($_SESSION['order']) || !isset($_SESSION['cart'])) {
               $_SESSION['cart_message'] = [
                    'text' => 'Không có thông tin đơn hàng',
                    'type' => 'error'
                ];
                header("Location: index.php?page=cart");
                exit;
            }
    
            $paymentMethod = intval($_POST['paymentMethod']); 
            $orderSession = $_SESSION['order'][0];
            
            if (empty($orderSession['idUser'])) { $orderSession['idUser'] = $_SESSION['user']; }
            require_once 'app/model/userModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserById($orderSession['idUser']);
            if (!$user) {
                echo "<script>location.href='index.php?page=logout';</script>";
                exit;
            }
    
            $dataOrder = [
                "shippingAddress" => $orderSession['address'],
                "idVoucher"       => $orderSession['idVoucher'] ?? null,
                "receiverPhone"   => $orderSession['phone'],
                "receiverName"    => $orderSession['name'],
                "idPayment"       => $paymentMethod,
                "totalPrice"      => $orderSession['totalPrice'],
                "dateOrder"       => date("Y-m-d H:i:s"),
                "orderStatus"     => 1, // 1 = Chờ thanh toán
                "idUser"          => $orderSession['idUser']
            ];
            
            // TẠO ĐƠN HÀNG VÀO DB
            $orderId = $this->order->insertOrder($dataOrder);
    
            // LƯU CHI TIẾT ĐƠN HÀNG
            foreach ($_SESSION['cart'] as $item) {
                $dataOrderItem = [
                    "idOrder"         => $orderId,
                    "idProductDetail" => $item['idProductDetail'],
                    "quantity"        => $item['quantity'],
                    "salePrice"       => $item['price']
                ];
                $this->orderItem->insertOrderItem($dataOrderItem);

                // Giảm tồn kho theo biến thể
                $this->productModel->decreaseStock($item['idProductDetail'], $item['quantity']);
            }

            // --- PHÂN LUỒNG THANH TOÁN ---
            
            // Nếu là VNPAY (Kiểm tra xem Value trong HTML của bạn là 2 hay số khác)
            if ($paymentMethod == 2) {
                $this->vnpayCreateUrl($orderId, $orderSession['totalPrice']);
                exit; // Dừng code để chuyển hướng
            }

            // NẾU LÀ COD -> Xử lý như cũ
            unset($_SESSION['cart']);
            unset($_SESSION['order']);
            $_SESSION['cart_total'] = 0;
    
             $_SESSION['cart_message'] = [
                'text' => 'Đặt hàng thành công',
                'type' => 'success'
            ];
            header("Location: index.php");
            exit;
        }
    }

    // 2. HÀM TẠO URL VNPAY
    public function vnpayCreateUrl($orderId, $amount) {
        $vnp_TxnRef = $orderId; 
        $vnp_OrderInfo = "Thanh toan don hang #" . $orderId;
        $vnp_Amount = $amount; 
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $this->vnp_Url . "?" . $query;
        if (isset($this->vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        header('Location: ' . $vnp_Url);
        die();
    }

    // 3. HÀM XỬ LÝ KHI VNPAY TRẢ VỀ
    public function vnpayReturn() {
        if(!isset($_GET['vnp_SecureHash'])) {
            echo "Dữ liệu không hợp lệ"; return;
        }
        
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
        
        if ($secureHash == $vnp_SecureHash) {
            $orderId = $_GET['vnp_TxnRef'];
            if ($_GET['vnp_ResponseCode'] == '00') {
                
                // Đặt về trạng thái chờ xác nhận (không chuyển sang vận chuyển)
                $this->order->updateOrderStatus($orderId, 1); 
                
                unset($_SESSION['cart']);
                unset($_SESSION['order']);
                $_SESSION['cart_total'] = 0;

               $_SESSION['cart_message'] = [
                    'text' => 'Thanh toán VNPAY thành công!',
                    'type' => 'success'
                ];
                header("Location: index.php?page=userOrder");
                exit;
            } else {
                 $_SESSION['cart_message'] = [
                    'text' => 'Thanh toán thất bại hoặc bị hủy',
                    'type' => 'error'
                ];
                header("Location: index.php?page=cart");
                exit;
            }
        } else {
            echo "Sai chữ ký bảo mật";
        }
    }
}
?>