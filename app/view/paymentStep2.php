<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| CHỌN NGUỒN ITEM (BUY NOW ƯU TIÊN)
|--------------------------------------------------------------------------
*/
$items = [];
$source = $_SESSION['checkout_source'] ?? null;

if ($source === 'buy_now' && !empty($_SESSION['buy_now'])) {
    $items = $_SESSION['buy_now'];

} elseif ($source === 'cart_checkbox' && !empty($_SESSION['checkout_items'])) {
    $items = $_SESSION['checkout_items'];

} else {
    // an toàn: không cho vào step 2 nếu không có dữ liệu hợp lệ
    header("Location: index.php?page=boxCart");
    exit;
}

/*
|--------------------------------------------------------------------------
| LẤY THÔNG TIN ORDER (STEP 1)
|--------------------------------------------------------------------------
*/
$name = $phone = $email = $address = '';
$shippingFee = 30000;
$discountOrder = 0;
$discountShipping = 0;
$voucherCode = '';

if (!empty($_SESSION['order'][0])) {
    $order = $_SESSION['order'][0];
    $name = $order['name'] ?? '';
    $phone = $order['phone'] ?? '';
    $email = $order['email'] ?? '';
    $address = $order['address'] ?? '';
    $shippingFee = $order['shippingFee'] ?? 30000;
    $discountOrder = $order['discountOrder'] ?? 0;
    $discountShipping = $order['discountShipping'] ?? 0;
    $voucherCode = $order['voucherCode'] ?? '';
}


?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thanh toán</title>
        <link rel="stylesheet" href="public/css/step2.css">

    </head>

    <body>
        <main class="paymentStep2">
            <div class="grid wide">
                <div class="row">
                    <!-- thông tin -->
                    <div class="col l-6 paymentStep2__order">
                        <div class="paymentStep2__order-title">Tóm tắt đơn hàng</div>
                        <!-- sp 1 -->
                        <?php
foreach ($items as $pro) {
    extract($pro);
?>
    <div class="paymentStep2__order-product mgt24 row" style="align-items:center; padding:10px 0; border-bottom:1px solid #eee;">

        <!-- CỘT 1: ẢNH -->
        <div class="col l-3">
            <img src="public/image/<?= $image ?>" 
                 alt="<?= $name ?>"
                 style="width:70px; height:70px; object-fit:cover; border-radius:6px; display:block;">
        </div>

        <!-- CỘT 2: TÊN + MÀU -->
        <div class="col l-6" style="display:flex; flex-direction:column; justify-content:center;">
            <p style="font-weight:600; margin:0 0 6px 0; line-height:20px;">
                <?= $name ?>
            </p>
            <p style=" margin:0; line-height:18px;">
                <span style="font-weight:600;">Màu:</span> <?= $colorName ?>
            </p>
        </div>

        <!-- CỘT 3: SỐ LƯỢNG -->
        <div class="col l-3" style="display:flex; flex-direction:column; align-items:flex-end; text-align:right;">
            <span style="font-size:14px;">Số lượng: <?= $quantity ?> cái</span>
        </div>
        <!-- Hidden gửi dữ liệu qua trang Order -->
        <input type="hidden" name="idProduct[]" value="<?= $id ?>">
        <input type="hidden" name="salePrice[]" value="<?= $price ?>">
        <input type="hidden" name="quantityItem[]" value="<?= $quantity ?>">


    </div>
<?php } ?>


                        <!-- địa chỉ -->
                        <?php
                        foreach ($_SESSION['order'] as $order) {
                            extract($order);

                            ?>
                            <div class="acceptInfo">
                                <div class="tcolor fs14 mgt24">
                                    <p>Người nhận</p>
                                </div>
                                <div class=" fs16 mgt20">
                                    <p><?= $name ?></p>
                                </div>
                                <div class="tcolor fs14 mgt24">
                                    <p>Số điện thoại</p>
                                </div>
                                <div class=" fs16 mgt20">
                                    <p><?= $phone ?></p>
                                </div>
                                <div class="tcolor fs14 mgt24">
                                    <p>Email</p>
                                </div>
                                <div class="fs16 mgt20">
                                    <p><?= htmlspecialchars($email) ?></p>
                                </div>
                                <div class="tcolor fs14 mgt24">
                                    <p>Địa chỉ</p>
                                </div>
                                <div class=" fs16 mgt20">
                                    <p><?= $address ?></p>
                                </div>
                                <!-- đơn vị vận chuyển -->
                                <div class="tcolor fs14 mgt24">
                                    <p>Đơn vị vận chuyển</p>
                                </div>
                                <div class=" fs16 mgt20">
                                    <p>JT Express</p>
                                </div>
                            </div>


                        <?php } ?>

                        <!-- thông tin giá -->
                        <?php
                        $tongsp = 0;
                        foreach ($items as $item) {
                            $tongsp += $item['price'] * $item['quantity'];
                        }
                       $orderSession = $_SESSION['order'][0] ?? [];
$shippingFee = $orderSession['shippingFee'] ?? 30000;
$discountOrder = $orderSession['discountOrder'] ?? 0;
$discountShipping = $orderSession['discountShipping'] ?? 0;
$voucherCode = $orderSession['voucherCode'] ?? '';

$grandTotal = ($tongsp + $shippingFee) - $discountOrder - $discountShipping;
if ($grandTotal < 0) $grandTotal = 0; // tránh âm

                        ?>
                        <div class="payment__infomation-summary">
                            <div class="summary-item">
                                <span>Sản phẩm</span>
                                <span><?= number_format($tongsp) ?> đ</span>
                            </div>
                            <div class="summary-item">
                                <span>Vận chuyển</span>
                                <span><?= number_format($shippingFee) ?> đ</span>
                            </div>
                            <?php if ($discountOrder > 0): ?>
                            <div class="summary-item">
                                <span>Giảm giá đơn</span>
                                <span>-<?= number_format($discountOrder) ?> đ</span>
                            </div>
                            <?php endif; ?>
                            <?php if ($discountShipping > 0): ?>
                            <div class="summary-item">
                                <span>Giảm phí ship</span>
                                <span>-<?= number_format($discountShipping) ?> đ</span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($voucherCode)): ?>
                            <div class="summary-item">
                                <span>Mã áp dụng</span>
                                <span><?= htmlspecialchars($voucherCode) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="summary-item total">
                                <strong>Tổng cộng</strong>
                                <strong><?= number_format($grandTotal) ?> đ</strong>
                                <input type="hidden" name="totalPrice" value="<?= $grandTotal ?>">
                            </div>
                        </div>
                    </div>

                    <!-- thanh toán -->
                    <div class="col l-1"></div>

                    <div class="col l-5 paymentStep2__pay">
                        <div class="paymentStep2__pay-btn">
                            <form method="POST" action="index.php?page=order">

                                <!-- NHÓM PHƯƠNG THỨC THANH TOÁN -->
                                <div class="payment-method-group">

                                    <label class="payment-method-radio">
                                        <input type="radio" name="paymentMethod" value="1" required>
                                        <span>Thanh toán khi nhận hàng</span>
                                    </label>

                                    <label class="payment-method-radio">
                                        <input type="radio" name="paymentMethod" value="2" required>
                                        <span>Chuyển khoản ngân hàng</span>
                                    </label>

                                </div>

                                <!-- NÚT -->
                                <div class="col l-12 paymentStep2_btn">
                                    <span class="paymentStep2__btn-prev fs16">
                                        <a href="index.php?page=payment">Trở lại</a>
                                    </span>

                                    <button name="submitOrder" class="paymentStep2__btn-next fs16">
                                        Đặt hàng
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
        </main>
    </body>

    </html>