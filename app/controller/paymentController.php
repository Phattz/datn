<?php 
class PaymentController {

    private $order;
    private $orderItem;
    private $productModel;
    /* ========== CẤU HÌNH VNPAY (SANDBOX) ========== */
    private $vnp_TmnCode    = "CGXZLS0Z"; 
    private $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; 
    private $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    private $vnp_Returnurl = "http://localhost/datn/index.php?page=vnpay_return";

    function __construct(){
        require_once 'app/model/orderModel.php';
        require_once 'app/model/orderItemModel.php';
        require_once 'app/model/productsModel.php';

        $this->order        = new OrderModel();
        $this->orderItem    = new OrderItemModel();
        $this->productModel = new ProductsModel();
    }

    /* ================== RENDER VIEW ================== */
    function renderView($view, $data = []) {
        extract($data);
        require_once 'app/view/'.$view.'.php';
    }

    /* ================== VIEW PAYMENT ================== */
    function viewPayment(){
        $data = [];

        if (empty($_SESSION['user'])) {
            $_SESSION['guest'] = true;
            $data['is_guest'] = true;
        } else {
            require_once 'app/model/userModel.php';
            $userModel = new UserModel();
            $data['userInfo'] = $userModel->getUserById($_SESSION['user']);
        }

        return $this->renderView('payment', $data);
    }

    /* ================== PAYMENT STEP 2 ================== */
    function viewPaymentStep2() {

        if (!isset($_POST['payment'])) return;

        $name    = $_POST['name'];
        $phone   = $_POST['phone'];
        $address = $_POST['address'];
        $email   = $_POST['email'] ?? null; 

        $idUser = $_SESSION['user'] ?? null;
        $voucherCode = trim($_POST['voucher_code'] ?? '');

        // ===== ƯU TIÊN BUY NOW =====
        $items = [];
        $source = $_SESSION['checkout_source'] ?? null;

        if ($source === 'buy_now' && !empty($_SESSION['buy_now'])) {
            $items = $_SESSION['buy_now'];

        } elseif ($source === 'cart_checkbox' && !empty($_SESSION['checkout_items'])) {
            $items = $_SESSION['checkout_items'];

        } else {
            $_SESSION['cart_message'] = [
                'text' => 'Không xác định được sản phẩm thanh toán',
                'type' => 'error'
            ];
            header("Location: index.php?page=boxCart");
            exit;
        }


        /* ===== TÍNH TỔNG TIỀN ===== */
        $productTotal = 0;
        foreach ($items as $item) {
            $productTotal += $item['price'] * $item['quantity'];
        }

        $shippingFee      = 30000;
        $discountOrder    = 0;
        $discountShipping = 0;
        $idVoucher        = null;

        /* ===== VOUCHER ===== */
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

            if ($productTotal < $voucher['minValue']) {
                $_SESSION['cart_message'] = [
                    'text' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher',
                    'type' => 'error'
                ];
                header("Location: index.php?page=payment");
                exit;
            }

            $value        = $voucher['discountValue'];
            $applyType    = $voucher['applyType'];
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

        /* ===== LƯU SESSION ORDER ===== */
        $_SESSION['order'][0] = [
            'name'             => $name,
            'phone'            => $phone,
            'address'          => $address,
            'email'            => $email, 
            'productTotal'     => $productTotal,
            'shippingFee'      => $shippingFee,
            'discountOrder'    => $discountOrder,
            'discountShipping' => $discountShipping,
            'totalPrice'       => $grandTotal,
            'idVoucher'        => $idVoucher,
            'voucherCode'      => $voucherCode,
            'idUser'           => $idUser
        ];

        $this->renderView('paymentStep2');
    }

    /* ================== CREATE ORDER ================== */
    function createOrder()
{
    // =========================
    // CHỐNG DOUBLE SUBMIT
    // =========================
    if (isset($_SESSION['order_processing'])) {
        return;
    }
    $_SESSION['order_processing'] = true;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submitOrder'])) {
        unset($_SESSION['order_processing']);
        return;
    }

    if (!isset($_POST['paymentMethod'])) {
        unset($_SESSION['order_processing']);
        $_SESSION['cart_message'] = [
            'text' => 'Vui lòng chọn phương thức thanh toán',
            'type' => 'error'
        ];
        header("Location: index.php?page=payment");
        exit;
    }

    /* ===== LẤY ITEM (ƯU TIÊN BUY NOW) ===== */
    $items = [];
    $source = $_SESSION['checkout_source'] ?? null;

    if ($source === 'buy_now' && !empty($_SESSION['buy_now'])) {
        $items = $_SESSION['buy_now'];

    } elseif ($source === 'cart_checkbox' && !empty($_SESSION['checkout_items'])) {
        $items = $_SESSION['checkout_items'];

    } else {
        unset($_SESSION['order_processing']);
        $_SESSION['cart_message'] = [
            'text' => 'Không xác định được sản phẩm đặt hàng',
            'type' => 'error'
        ];
        header("Location: index.php?page=boxCart");
        exit;
    }

    if (!isset($_SESSION['order']) || empty($items)) {
        unset($_SESSION['order_processing']);
        $_SESSION['cart_message'] = [
            'text' => 'Không có thông tin đơn hàng',
            'type' => 'error'
        ];
        header("Location: index.php?page=cart");
        exit;
    }

    $orderSession  = $_SESSION['order'][0];
    $paymentMethod = intval($_POST['paymentMethod']);
    $idUser        = $_SESSION['user'] ?? null;

    $dataOrder = [
        "shippingAddress" => $orderSession['address'],
        "idVoucher"       => $orderSession['idVoucher'] ?? null,
        "receiverPhone"   => $orderSession['phone'],
        "receiverName"    => $orderSession['name'],
        "receiverEmail"   => $orderSession['email'],
        "idPayment"       => $paymentMethod,
        "totalPrice"      => $orderSession['totalPrice'],
        "dateOrder"       => date("Y-m-d H:i:s"),
        "orderStatus"     => 1,
        "idUser"          => $idUser
    ];

    /* ===== TẠO ĐƠN ===== */
    $orderId = $this->order->insertOrder($dataOrder);

    if (!$orderId) {
        unset($_SESSION['order_processing']);
        $_SESSION['cart_message'] = [
            'text' => 'Không thể tạo đơn hàng, vui lòng thử lại',
            'type' => 'error'
        ];
        header("Location: index.php?page=payment");
        exit;
    }

    /* ===== CHI TIẾT ĐƠN + TRỪ KHO ===== */
    foreach ($items as $item) {

        $this->orderItem->insertOrderItem([
            "idOrder"         => $orderId,
            "idProductDetail" => $item['idProductDetail'],
            "quantity"        => $item['quantity'],
            "salePrice"       => $item['price']
        ]);

        $this->productModel->decreaseStock(
            $item['idProductDetail'],
            $item['quantity']
        );
    }

    // ===== CLEAR SESSION ĐÚNG CASE =====
    

    // Nếu mua từ checkbox → chỉ remove item đã mua
    if (!empty($_SESSION['checkout_items']) && !empty($_SESSION['cart'])) {

    $boughtIds = array_column($items, 'idProductDetail');

    $_SESSION['cart'] = array_values(array_filter(
        $_SESSION['cart'],
        function ($cartItem) use ($boughtIds) {
            return !in_array($cartItem['idProductDetail'], $boughtIds);
        }
    ));

    // cập nhật lại cart_total nếu bạn có dùng
    $_SESSION['cart_total'] = count($_SESSION['cart']);
}
unset($_SESSION['buy_now'], $_SESSION['order'], $_SESSION['checkout_items']);

    /* ===== GỬI MAIL ===== */
    if (!empty($orderSession['email'])) {
        require_once 'app/controller/MailerController.php';
        $mailer = new MailerController();

        $orderDetails = $this->order->getOrderDetailsWithImages($orderId);

        $mailer->sendOrderEmail(
            $orderSession['email'],
            [
                'id'         => $orderId,
                'dateOrder'  => $dataOrder['dateOrder'],
                'totalPrice' => $dataOrder['totalPrice']
            ],
            $orderDetails
        );
    }

    /* ===== THANH TOÁN ===== */
    if ($paymentMethod == 2) {
        unset($_SESSION['order_processing']);
        $this->vnpayCreateUrl($orderId, $orderSession['totalPrice']);
        exit;
    }

    // COD
    unset($_SESSION['order_processing']);
    $_SESSION['cart_message'] = [
        'text' => 'Đặt hàng thành công',
        'type' => 'success'
    ];
    header("Location: index.php");
    exit;
}

    public function showPayment()
    {
        $data = [];

        // ===== LẤY VOUCHER =====
        require_once 'app/model/voucherModel.php';
        $voucherModel = new VoucherModel();
        $data['listVoucher'] = $voucherModel->getAllVouchersActive();

        // ===== LẤY USER ĐÃ ĐĂNG NHẬP (CHUẨN) =====
        if (!empty($_SESSION['user'])) {
            require_once 'app/model/userModel.php';
            $userModel = new UserModel();
            $data['userInfo'] = $userModel->getUserById($_SESSION['user']);
        }

        return $this->renderView('payment', $data);
    }

    /* ================== VNPAY CREATE ================== */
    public function vnpayCreateUrl($orderId, $amount) {

        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_TmnCode"   => $this->vnp_TmnCode,
            "vnp_Amount"    => $amount * 100,
            "vnp_Command"   => "pay",
            "vnp_CreateDate"=> date('YmdHis'),
            "vnp_CurrCode"  => "VND",
            "vnp_IpAddr"    => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale"    => "vn",
            "vnp_OrderInfo" => "Thanh toan don hang #".$orderId,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef"    => $orderId
        ];

        ksort($inputData);
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key)."=".urlencode($value)."&";
        }

        $hashdata = rtrim($hashdata, "&");
        $secureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);

        $query = http_build_query($inputData) . '&vnp_SecureHash=' . $secureHash;
        header('Location: '.$this->vnp_Url.'?'.$query);
        exit;
    }

    /* ================== VNPAY RETURN ================== */
    public function vnpayReturn() {

        if (!isset($_GET['vnp_SecureHash'])) return;

        $secureHash = $_GET['vnp_SecureHash'];
        $inputData  = [];

        foreach ($_GET as $key => $value) {
            if (strpos($key, 'vnp_') === 0 && $key !== 'vnp_SecureHash') {
                $inputData[$key] = $value;
            }
        }

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key)."=".urlencode($value)."&";
        }

        $hashData = rtrim($hashData, "&");
        $checkHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        if ($checkHash === $secureHash && $_GET['vnp_ResponseCode'] === '00') {

            $orderId = $_GET['vnp_TxnRef'];
            $this->order->updateOrderStatus($orderId, 1);

            unset($_SESSION['cart'], $_SESSION['buy_now'], $_SESSION['order']);
            $_SESSION['cart_total'] = 0;

            $_SESSION['cart_message'] = [
                'text' => 'Thanh toán VNPAY thành công!',
                'type' => 'success'
            ];
            header("Location: index.php?page=userOrder");
            exit;
        }

        $_SESSION['cart_message'] = [
            'text' => 'Thanh toán thất bại hoặc bị hủy',
            'type' => 'error'
        ];
        header("Location: index.php?page=cart");
        exit;
    }
   
    
}
