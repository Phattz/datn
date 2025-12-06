
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="public/css/boxCart.css">


<section class="cart-shopee">
    <div class="cart-container">
        <h2>Giỏ hàng</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
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
                        <!-- Hình ảnh -->
                        <td class="cart-image">
                            <img src="public/image/<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                        </td>

                        <!-- Tên sản phẩm -->
                        <td class="cart-name">
                            <p class="product-name"><?= $item['name'] ?></p>
                        </td>
                        <!-- màu sắc -->
                          <td class="cart-color">
                            <p class="product-color"><?= $item['color'] ?></p>
                          </td>
                        <!-- Đơn giá -->
                        <td><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>

                        <!-- Số lượng -->
                        <td>
    <button class="qty-btn" onclick="updateCart('giam', <?= $item['id'] ?>, '<?= $item['color'] ?>')">−</button>
    <span class="qty-number"><?= $item['quantity'] ?></span>
    <button class="qty-btn" onclick="updateCart('tang', <?= $item['id'] ?>, '<?= $item['color'] ?>')">+</button>
</td>


                        <!-- Thành tiền -->
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫</td>

                        <!-- Xóa -->
                        <td>
                            <form action="index.php?page=removeFromCart" method="post">
    <input type="hidden" name="deletePro" value="<?= $item['id'] ?>">
    <button name="removeFromCart">Xóa</button>
</form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p>Tổng cộng (<?= $totalPro ?> sản phẩm): <strong><?= number_format($totalPrice, 0, ',', '.') ?> ₫</strong></p>
                <?php if (!empty($_SESSION['user'])): ?>
                    <a href="index.php?page=payment"><button class="checkout-btn">Mua hàng</button></a>
                <?php else: ?>
                    <a href="index.php?page=login"><button class="checkout-btn">Đăng nhập để thanh toán</button></a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="empty-cart">Giỏ hàng trống.</p>
        <?php endif; ?>
    </div>
</section>
<script src="public/js/.js"></script>