<?php
$_SESSION['redirect_after_login'] = "index.php?page=boxCart";
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="public/css/boxCart.css">
<!-- TOAST CSS -->
<style>
        #toast-msg-fixed {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 26px;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            z-index: 999999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        #toast-msg-fixed.success { background: #4CAF50; }
        #toast-msg-fixed.error { background: #E53935; }
        #toast-msg-fixed.hide { opacity: 0; }
    </style>
<body>
    <!-- TOAST MESSAGE -->
    <?php if (!empty($_SESSION['cart_message'])): ?>
        <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
            <?= $_SESSION['cart_message']['text']; ?>
        </div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>
     <!-- AUTO HIDE TOAST -->
     <script>
    document.addEventListener("DOMContentLoaded", function () {
        const toast = document.getElementById("toast-msg-fixed");
        if (toast) {
            setTimeout(() => {
                toast.classList.add("hide");
                setTimeout(() => toast.remove(), 500);
            }, 2000);
        }
    });
    </script>
<section class="cart-shopee">
    <div class="cart-container">
        <h2>Giỏ hàng</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="check-all" checked>
                        </th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPro = 0;
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $item):
                        $totalPro += $item['quantity'];
                        $totalPrice += $item['price'] * $item['quantity'];
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox"class="cart-item-checkbox"value="<?= $item['idProductDetail'] ?>"data-price="<?= $item['price'] ?>"data-qty="<?= $item['quantity'] ?>"checked>
                        </td>
                        <!-- Hình ảnh -->
                        <td class="cart-image">
                            <a href="index.php?page=productDetail&id=<?= $item['id'] ?>">
                                <img src="public/image/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                            </a>
                        </td>

                        <!-- Tên sản phẩm -->
                        <td class="cart-name">
                            <p class="product-name">
                                <a href="index.php?page=productDetail&id=<?= $item['id'] ?>">
                                    <?= $item['name'] ?>
                                </a>
                            </p>
                        </td>

                        <!-- màu sắc -->
                        <td class="cart-color">
                            <p class="product-color">
                                <?= isset($item['colorName']) ? $item['colorName'] : $item['color'] ?>
                            </p>
                        </td>

                        <!-- Đơn giá -->
                        <td><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>

                        <!-- Số lượng -->
                <td>
                    <a href="?ctrl=cart&act=decrease&proId=<?= $item['id'] ?>&color=<?= $item['color'] ?>">−</a>
                    <span><?= $item['quantity'] ?></span>
                    <a href="?ctrl=cart&act=increase&proId=<?= $item['id'] ?>&color=<?= $item['color'] ?>">+</a>
                </td>



                        <!-- Thành tiền -->
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫</td>

                        <!-- Xóa -->
                        <td>
                        <form action="index.php?page=removeFromCart" method="post">
                            <input type="hidden" name="deletePro" value="<?= $item['id'] ?>">
                            <input type="hidden" name="deleteColor" value="<?= $item['color'] ?>">
                            <button name="removeFromCart">Xóa</button>
                        </form>


                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p>Đã chọn <span id="selectedCount">0</span> sản phẩm, tổng cộng: <strong><span id="selectedTotal">0</span> ₫</strong></p>
                <?php if (!empty($_SESSION['user'])): ?>
                    <form id="checkoutForm" method="post"action="index.php?ctrl=cart&act=checkoutFromCart">
                        <input type="hidden" name="selected_items" id="selected_items">

                        <button type="submit" class="checkout-btn">
                            Mua hàng
                        </button>
                    </form>


                    <?php else: ?>
                        <div class="cart-action-not-login">

                            <!-- MUA NGAY: KHÔNG CẦN LOGIN -->
                            <?php
                                if (!empty($_SESSION['cart'])) {
                                    $_SESSION['checkout_source'] = 'buy_now';
                                    $_SESSION['buy_now'] = $_SESSION['cart'];
                                }
                                ?>
                                <a href="index.php?page=payment" class="cart-btn">
                                    Mua ngay
                                </a>

                            <!-- ĐĂNG NHẬP: MỞ POPUP LOGIN Ở HEADER -->
                            <a href="javascript:void(0)" class="cart-btn popup-dangnhap">
                                Đăng nhập để thanh toán
                            </a>

                        </div>
                    <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="empty-cart">Giỏ hàng trống.</p>
        <?php endif; ?>
    </div>
</section>
</body>
<script src="public/js/boxcart.js"></script>
