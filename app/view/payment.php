<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/payment.css">
    <style>
        /* CSS bổ sung cho phần chọn Voucher */
        .voucher-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            font-size: 14px;
            outline: none;
            cursor: pointer;
        }
        .voucher-select:focus {
            border-color: #d32f2f;
        }
        .voucher-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<main class="payment">
    <div class="grid wide">
        <div class="row">

            <div class="col l-12 payment__title">
                <p class="payment__title-text">Thanh toán</p>
            </div>

            <div class="col l-6 payment__product">
                <?php
                $tongsp = 0;

                // ===== ƯU TIÊN MUA NGAY =====
                $items = [];
                $source = $_SESSION['checkout_source'] ?? null;

                if ($source === 'buy_now') {
                    $items = $_SESSION['buy_now'] ?? [];
                } elseif ($source === 'cart_checkbox') {
                    $items = $_SESSION['checkout_items'] ?? [];
                } else {
                    $items = $_SESSION['cart'] ?? [];
                }
                
                foreach ($items as $item) {
                    extract($item);
                    $tong1sp = $price * $quantity;
                    $tongsp += $tong1sp;
                ?>
                

                <div class="payment__product-item row">
                    <div class="col l-3 product-img">
                        <img src="public/image/<?= $image ?>" 
                            alt="<?= $image ?>"
                            style="width:80px; height:80px; object-fit:cover; border-radius:6px; display:block; margin-top: 30px;">
                    </div>

                    <div class="col l-4 product-info">
                        <p class="product-name" style="font-weight:700; margin-bottom:15px; line-height:20px;">
                            <?= $name ?>
                        </p>
                        <p class="product-color" style="margin-top:5px; line-height:20px;">
                            <span style="font-weight:700;">Màu:</span>
                            <?= $colorName ?>
                        </p>
                    </div>

                    <div class="col l-2 product-qty" style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
                        <span style="font-weight:700; font-size:14px; margin-bottom:19px;">Số lượng:</span>
                        <input type="text" value="<?= $quantity ?>" readonly style="text-align:center; border:none; outline:none; background:transparent; font-size:14px;">
                    </div>

                    <div class="col l-3 product-price">
                        <span style="font-weight:700;">Số tiền:</span><br>
                        <span style="display:block; margin-top: 20px; font-size:16px;"><?= number_format($tong1sp) ?> đ</span>
                    </div>
                </div>

                <?php
                    }
                ?>
            </div>

            <div class="col l-6 payment__infomation" style="margin-top: 40px;">
                <p>Thông tin thanh toán</p>

                <div class="payment__info">
                    <form action="index.php?page=paymentStep2" method="post">

                    <?php
                        $nameValue = "";
                        $phoneValue = "";
                        $addressValue = "";
                        $emailValue = "";

                        /* ===== ƯU TIÊN USER ĐÃ ĐĂNG NHẬP ===== */
                        if (isset($data['userInfo'])) {
                            $user = $data['userInfo'];
                            $nameValue    = $user['name'] ?? '';
                            $phoneValue   = $user['phone'] ?? '';
                            $addressValue = $user['address'] ?? '';
                            $emailValue   = $user['email'] ?? '';
                        }

                        /* ===== NẾU CÓ SESSION ORDER (QUAY LẠI BƯỚC TRƯỚC) → GHI ĐÈ ===== */
                        if (!empty($_SESSION['order'][0])) {
                            $order = $_SESSION['order'][0];
                            $nameValue    = $order['name'] ?? $nameValue;
                            $phoneValue   = $order['phone'] ?? $phoneValue;
                            $addressValue = $order['address'] ?? $addressValue;
                            $emailValue   = $order['email'] ?? $emailValue;
                        }
                    ?>

                        <label for="name">Tên người nhận</label>
                        <input type="text" name="name" value="<?= $nameValue ?>" placeholder="Họ và tên" required>

                        <label for="phone">Số điện thoại người nhận</label>
                        <input type="text" name="phone" value="<?= $phoneValue ?>" placeholder="Số điện thoại" pattern="^0\d{9}$" required>
                        <label for="email">Email người nhận</label>
                        <input type="email"name="email"value="<?= htmlspecialchars($emailValue) ?>"placeholder="Nhập email người nhận"required>
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" required><?= $addressValue ?></textarea>

                        <div class="voucher-container">
                            <label for="voucher_code">Ưu đãi / Mã giảm giá</label>
                            <div style="display:flex; flex-direction: column; gap:5px;">
                                <select name="voucher_code" class="voucher-select">
                                    <option value="">-- Chọn Voucher khả dụng --</option>
                                    <?php 
                                    // GẮN DỮ LIỆU TỪ DB VÀO ĐÂY
                                    if (isset($data['listVoucher']) && !empty($data['listVoucher'])) {
                                        foreach ($data['listVoucher'] as $vc) {
                                            // Sử dụng cột 'name' làm mã và 'description' để hiển thị
                                            echo '<option value="'.$vc['name'].'">'.$vc['name'].' - '.$vc['description'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php if (isset($_SESSION['cart_message'])): ?>
    <div class="alert <?= $_SESSION['cart_message']['type'] ?>" 
         style="padding:10px; margin-bottom:15px; border:1px solid #f00; color:#f00; background:#ffecec;">
        <?= $_SESSION['cart_message']['text'] ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

                                <small style="color:#8d6e6e; font-style: italic;">
                                    <i class="fa-solid fa-circle-info"></i> Mã giảm giá sẽ được áp dụng ở bước tiếp theo.
                                </small>
                            </div>
                        </div>

                        <?php 
                            $shippingFee = 30000;
                            $grandTotal = $tongsp + $shippingFee;
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

                            <div class="summary-item total">
                                <strong>Tổng cộng</strong>
                                <strong><?= number_format($grandTotal) ?> đ</strong>
                            </div>

                            <input type="hidden" name="totalPrice" value="<?= $grandTotal ?>">
                        </div>

                        <button type="submit" name="payment" class="payment-button">Tiếp tục thanh toán</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

</body>
</html>