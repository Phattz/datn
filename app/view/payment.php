<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/payment.css">
</head>

<body>

<main class="payment">
    <div class="grid wide">
        <div class="row">

            <!-- TIÊU ĐỀ -->
            <div class="col l-12 payment__title">
                <p class="payment__title-text">Thanh toán</p>
            </div>

            <!-- BÊN TRÁI — DANH SÁCH SẢN PHẨM -->
            <div class="col l-6 payment__product">
                <?php
                $tongsp = $data['totalProducts'] ?? 0;
                $shippingFee = $data['shippingFee'] ?? 30000;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        extract($item);
                        $tong1sp = $price * $quantity;
                ?>

                <div class="payment__product-item row">

                    <!-- CỘT 1: HÌNH -->
                    <div class="col l-3 product-img">
                        <img src="public/image/<?= $image ?>" 
                            alt="<?= $image ?>"
                            style="width:80px; height:80px; object-fit:cover; border-radius:6px; display:block; margin-top: 30px;">
                    </div>


                    <!-- CỘT 2: TÊN + MÀU -->
                    <div class="col l-4 product-info">

                        <p class="product-name" 
                            style="font-weight:700; margin-bottom:15px; line-height:20px;">
                            <?= $name ?>
                        </p>

                        <p class="product-color" 
                            style="margin-top:5px; line-height:20px;">
                            <span style="font-weight:700;">Màu:</span>
                            <?= $colorName ?>
                        </p>


                    </div>


                    <!-- CỘT 3: SỐ LƯỢNG -->
                    <div class="col l-2 product-qty"
                        style="display:flex; flex-direction:column; align-items:center; justify-content:center;">

                        <span style="font-weight:700; font-size:14px; margin-bottom:19px;">
                            Số lượng:
                        </span>

                        <input type="text"
                            value="<?= $quantity ?>"
                            readonly
                            style="
                                text-align:center;
                                border:none;
                                outline:none;
                                background:transparent;
                                font-size:14px;
                            ">
                    </div>




                    <!-- CỘT 4: GIÁ -->
                    <div class="col l-3 product-price">
                    <span style="font-weight:700;">Số tiền:</span><br>

                    <span style= "display:block; margin-top: 20px; font-size:16px;"><?= number_format($tong1sp) ?> đ</span>
                    </div>

                </div>

                <?php
                    }
                }
                ?>
            </div>

            <!-- BÊN PHẢI: FORM THÔNG TIN -->
            <div class="col l-6 payment__infomation "style="margin-top: 40px;">
                <p>Thông tin thanh toán</p>

                <div class="payment__info">
                    <form action="index.php?page=paymentStep2" method="post">

                    <?php
                        // Ưu tiên: lấy từ session ORDER (nếu là bước quay lại)
                        // Nếu không có → lấy thông tin User đã lưu
                        $nameValue = "";
                        $phoneValue = "";
                        $addressValue = "";

                        if (isset($_SESSION['order'])) {
                            $order = $_SESSION['order'][0];
                            $nameValue = $order['name'];
                            $phoneValue = $order['phone'];
                            $addressValue = $order['address'];
                        
                        } elseif (isset($data['userInfo'])) {
                            $nameValue = $data['userInfo']['name'];
                            $phoneValue = $data['userInfo']['phone'];
                            $addressValue = $data['userInfo']['address'];
                        }
                        ?>

                        <label for="name">Tên người nhận</label>
                        <input type="text" name="name" value="<?= $nameValue ?>" placeholder="Họ và tên" required>

                        <label for="phone">Số điện thoại người nhận</label>
                        <input type="text" name="phone" value="<?= $phoneValue ?>" placeholder="Số điện thoại" pattern="^0\d{9}$" required>

                        <label for="address">Địa chỉ</label>
                        <textarea name="address" required><?= $addressValue ?></textarea>


                        <div class="payment__infomation-summary">
                            <div class="summary-item">
                                <span>Sản phẩm</span>
                                <span><?= number_format($tongsp) ?> đ</span>
                            </div>

                            <div class="summary-item">
                                <span>Vận chuyển</span>
                                <span><?= number_format($shippingFee) ?> đ</span>
                            </div>

                            <?php
                                $voucherDiscount = 0;
                                if (isset($_SESSION['voucher'])) {
                                    $voucherDiscount = $_SESSION['voucher']['discount'];
                                }
                                $grandTotal = $tongsp + $shippingFee - $voucherDiscount;
                                if ($grandTotal < 0) $grandTotal = 0;
                            ?>

                            <?php if ($voucherDiscount > 0): ?>
                            <div class="summary-item">
                                <span>Giảm giá (voucher)</span>
                                <span>-<?= number_format($voucherDiscount) ?> đ</span>
                            </div>
                            <?php endif; ?>

                            <div class="summary-item total">
                                <strong>Tổng cộng</strong>
                                <strong><?= number_format($grandTotal) ?> đ</strong>
                            </div>

                            <input type="hidden" name="totalPrice" value="<?= $grandTotal ?>">
                        </div>

                        <button name="payment" class="payment-button">Thanh toán</button>

                    </form>

                    <form action="index.php?page=payment" method="post" class="voucher-form">
                        <input type="text" name="voucher_code" placeholder="Nhập mã voucher" value="<?= isset($_SESSION['voucher']['code']) ? $_SESSION['voucher']['code'] : '' ?>">
                        <button type="submit" name="apply_voucher" class="payment-button">Áp mã</button>
                    </form>
                    <?php if (isset($data['voucherError'])): ?>
                        <p class="voucher-message error"><?= $data['voucherError'] ?></p>
                    <?php elseif (isset($data['voucherSuccess'])): ?>
                        <p class="voucher-message success"><?= $data['voucherSuccess'] ?></p>
                    <?php elseif (isset($_SESSION['voucher']['code'])): ?>
                        <p class="voucher-message success">Đã áp dụng voucher: <?= htmlspecialchars($_SESSION['voucher']['code']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

</body>

</html>