<?php
// Xử lý form khi được gửi
$selectedMethod = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['paymentMethod'])) {
        $selectedMethod = $_POST['paymentMethod']; // Lấy phương thức thanh toán được chọn
    }
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
                    foreach ($_SESSION['cart'] as $pro) {
                        extract($pro);

                        ?>
                        <div class="paymentStep2__order-product mgt24">
                            <div class="img__title">
                                <img src="public/image/<?= $image ?>" alt="">
                                <p><?= $name ?></p>
                            </div>
                            <div class="paymentStep2__product-price">
                                <p><?= $quantity ?> cái</p>
                            </div>
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
                    $tongsp = null;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            extract($item);
                            $tong1sp = $price * $quantity;
                            $tongsp += $tong1sp;
                        }
                    }

                    ?>
                    <div class="payment__infomation-summary">
                        <div class="summary-item">
                            <span>Sản phẩm</span>
                            <span><?= number_format($tongsp) ?> đ</span>
                        </div>
                        <div class="summary-item">
                            <span>Vận chuyển</span>
                            <span>0đ</span>
                        </div>
                        <div class="summary-item total">
                            <strong>Tổng cộng</strong>
                            <strong><?= number_format($tongsp) ?> đ</strong>
                            <input type="hidden" name="totalPrice" value="<?= $tongsp ?>">
                        </div>
                    </div>
                </div>

                <!-- thanh toán -->
                <div class="col l-1"></div>

                <div class="col l-5 paymentStep2__pay">
                    <div class="paymentStep2__pay-btn">
                        <form method="POST" action="index.php?page=order">
                            <label class="payment-radio">
                                <input id="btnCOD" type="radio" name="paymentMethod" value="1">
                                Thanh toán khi nhận hàng
                            </label>
                        


                            <div class="col l-12 paymentStep2_btn">
                                <span class="paymentStep2__btn-prev fs16"><a href="index.php?page=payment">Trở lại</a></span>
                                <button name="submitOrder" class="paymentStep2__btn-next fs16">Đặt hàng</button>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
    </main>
</body>

</html>