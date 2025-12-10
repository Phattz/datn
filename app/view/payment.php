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
    <!-- header -->
    <!-- payment -->
    <main class="payment">
        <div class="grid wide">
            <div class="row">
                <div class="col l-12 payment__title">
                    <p class="payment__title-text">Thanh toán</p>
                </div>
                <div class="col l-6 payment__product">
                    <?php
                    $tongsp = null;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            extract($item);

                            ?>
                            <div class="payment__product-item row">
                                <div class="col l-6 payment__product-item-left">
                                    <img src="public/image/<?= $image ?>" alt="<?= $image ?>">
                                    <p><?= $name ?></p>
                                    <input type="hidden" name="idProduct" value="<?= $id ?>">
                                </div>
                                <div class="col l-6 "
                                    style="display: flex; align-items: center; justify-content: space-around;">
                                    <span class="payment__item-action-quantity">
                                        <input type="text" id="quantity" value="<?= $quantity ?>">
                                    </span>
                                    <span class="payment__item-price">
                                        <p>
                                            <?php
                                            $tong1sp = $price * $quantity;
                                            $tongsp += $tong1sp;
                                            echo number_format($tong1sp) . ' đ';
                                            ?>
                                        </p>
                                    </span>
                                    <!-- <span class="payment__item-action">
                                        <i class="fa-regular fa-circle-xmark"></i>
                                    </span> -->
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>

                </div>
                <div class="col l-6 payment__infomation">
                    <p>Thông tin thanh toán</p>
                    <div class="payment__info">
                        <form action="index.php?page=paymentStep2" method="post">
    <?php foreach ($_SESSION['cart'] as $item): ?>
        <input type="hidden" name="products[]" value="<?= $item['id'] ?>">
        <input type="hidden" name="quantities[]" value="<?= $item['quantity'] ?>">
        <input type="hidden" name="prices[]" value="<?= $item['price'] ?>">
    <?php endforeach; ?>

    <!-- thông tin người nhận -->
    <label for="name">Tên người nhận</label>
    <input type="text" name="name" placeholder="Họ và tên" required />

    <label for="phone">Số điện thoại người nhận</label>
    <input type="text" name="phone" placeholder="Số điện thoại" pattern="^0\d{9}$" required />

    <label for="address">Địa chỉ</label>
    <textarea name="address" placeholder="Vui lòng nhập địa chỉ cụ thể" rows="2" cols="10" required></textarea>

    <!-- tổng tiền -->
<?php if (isset($tongsp)): ?>
    <input type="hidden" name="totalPrice" value="<?= $tongsp ?>">
<?php endif; ?>

    <button name="payment" class="payment-button">Thanh toán</button>
</form>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
</body>

</html>