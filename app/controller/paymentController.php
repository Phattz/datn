<?php 
class PaymentController{
    private $order;
    private $orderItem;
    private $voucher;
    function __construct(){
        $this->order = new OrderModel();
        $this->orderItem = new OrderItemModel();
        $this->voucher = new VoucherModel();
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

        // TÍNH TỔNG SẢN PHẨM
        $totalProducts = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $totalProducts += ($item['price'] * $item['quantity']);
            }
        }
        $shippingFee = 30000;

        // APPLY VOUCHER (nếu có POST áp mã)
        if (isset($_POST['apply_voucher']) && isset($_POST['voucher_code'])) {
            $code = trim($_POST['voucher_code']);
            $voucher = $this->voucher->findActiveByCode($code);
            if (!$voucher) {
                $data['voucherError'] = "Mã voucher không hợp lệ hoặc đã hết hạn.";
                unset($_SESSION['voucher']);
            } else {
                $applied = $this->voucher->applyVoucher($voucher, $totalProducts, $shippingFee);
                $_SESSION['voucher'] = [
                    'id'        => $voucher['id'],
                    'code'      => $voucher['name'],
                    'discount'  => $applied['discount'],
                    'shippingFee' => $applied['shippingFee'],
                    'applyType' => $voucher['applyType'],
                    'discountType' => $voucher['discountType'],
                    'discountValue' => $voucher['description'], // lưu mô tả để biết giá trị
                ];
                $shippingFee = $applied['shippingFee'];
                $totalProducts = $applied['totalProducts'];
                $data['voucherSuccess'] = "Áp dụng voucher thành công.";
            }
        } elseif (isset($_SESSION['voucher'])) {
            // nếu đã có voucher trong session thì tính lại
            $voucher = $this->voucher->findActiveByCode($_SESSION['voucher']['code']);
            if ($voucher) {
                $applied = $this->voucher->applyVoucher($voucher, $totalProducts, $shippingFee);
                $shippingFee = $applied['shippingFee'];
                $totalProducts = $applied['totalProducts'];
                $_SESSION['voucher']['discount'] = $applied['discount'];
                $_SESSION['voucher']['shippingFee'] = $applied['shippingFee'];
            } else {
                unset($_SESSION['voucher']);
            }
        }

        $data['totalProducts'] = $totalProducts;
        $data['shippingFee'] = $shippingFee;

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

            // TÍNH TỔNG TIỀN SẢN PHẨM + PHÍ VẬN CHUYỂN (30k)
            $totalProducts = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $totalProducts += ($item['price'] * $item['quantity']);
                }
            }
            $shippingFee = 30000;

            // ÁP VOUCHER (nếu còn hợp lệ)
            $idVoucher = null;
            $totalWithShipping = $totalProducts + $shippingFee;
            $voucherDiscount = 0;
            $voucherCode = null;
            if (isset($_SESSION['voucher'])) {
                $voucher = $this->voucher->findActiveByCode($_SESSION['voucher']['code']);
                if ($voucher) {
                    $applied = $this->voucher->applyVoucher($voucher, $totalProducts, $shippingFee);
                    $shippingFee = $applied['shippingFee'];
                    $totalProducts = $applied['totalProducts'];
                    $totalWithShipping = $applied['totalFinal'];
                    $idVoucher = $voucher['id'];
                    $voucherDiscount = $applied['discount'];
                    $voucherCode = $voucher['name'];
                }
            }
    
            $dataOrder = [
                "shippingAddress" => $orderSession['address'],
                "idVoucher"       => $idVoucher,
                "receiverPhone"   => $orderSession['phone'],
                "receiverName"    => $orderSession['name'],
                "idPayment"       => $paymentMethod,
                "totalPrice"      => $totalWithShipping,
                "shippingFee"     => $shippingFee,
                "voucherDiscount" => $voucherDiscount,
                "voucherCode"     => $voucherCode,
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
            unset($_SESSION['voucher']);
    
            echo "<script>alert('Đặt hàng thành công')</script>";
            echo "<script>location.href='index.php?page=index.php';</script>";
        }
    }
    
    }
 