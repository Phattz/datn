<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chủ</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/main.css">

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
</head>

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


    <!-- ============================================================= -->
    <main class="grid wide">
       <div class="slider">
    <img src="public/image/banner-4.png" class="slide active">
    <img src="public/image/banner-5.png" class="slide">
    <img src="public/image/banner-6.jpg" class="slide">
</div>

        <!-- SẢN PHẨM MỚI -->
        <section class="row">
            <div class="title-box">
                <h3>Sản phẩm mới</h3>
            </div>

            <div class="row">
                <?php foreach ($data['product8'] as $item): ?>
                    <?php if ($item['status'] == 1): ?>
                        <div class="col l-3 m-4 c-12">
                            <div class="product">

                                <a href="index.php?page=productDetail&id=<?= $item['id'] ?>">
                                    <div class="img-product">
                                        <img src="public/image/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="name-product">
                                        <span><?= $item['name'] ?></span>
                                    </div>
                                    <div class="price-product">
                                        <span><?= number_format($item['price']) ?> đ</span>
                                    </div>
                                </a>

                                <form action="index.php?page=addToCart" method="post" class="addCart-product">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $item['name'] ?>">
                                    <input type="hidden" name="product_price" value="<?= $item['price'] ?>">
                                    <input type="hidden" name="product_image" value="<?= $item['image'] ?>">
                                    <input type="hidden" name="product_color" value="<?= $item['idColor'] ?>">
                                    <input type="hidden" name="product_detail_id">
                                    <input type="hidden" name="product_quantity" value="1">

                                    <button type="submit" name="addToCart" class="addCart-product">
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>

                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>


        <!-- SẢN PHẨM NỔI BẬT -->
        <section class="row">
            <div class="title-box">
                <h3>Sản phẩm nổi bật</h3>
            </div>

            <div class="col l-12 m-12 c-12" style="padding:0;">
                <div class="box-hot-product">

                    <button class="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>

                    <div class="products-container">
                        <?php foreach ($data['product6'] as $item): ?>
                            <div class="product">

                                <a href="index.php?page=productDetail&id=<?= $item['id'] ?>">
                                    <div class="img-product">
                                        <img src="public/image/<?= $item['image'] ?>" alt="">
                                    </div>
                                    <div class="name-product">
                                        <span><?= $item['name'] ?></span>
                                    </div>
                                    <div class="price-product">
                                        <span><?= number_format($item['price']) ?> đ</span>
                                    </div>
                                </a>

                                <form action="index.php?page=addToCart" method="post" class="addCart-product">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $item['name'] ?>">
                                    <input type="hidden" name="product_price" value="<?= $item['price'] ?>">
                                    <input type="hidden" name="product_image" value="<?= $item['image'] ?>">
                                    <input type="hidden" name="product_color" value="<?= $item['idColor'] ?>">
                                    <input type="hidden" name="product_quantity" value="1">

                                    <button type="submit" name="addToCart" class="addCart-product">
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>

                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="next-btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </section>


        <!-- CHÍNH SÁCH (ICON) -->
        <section class="row policy-icons">
            <div class="col l-4 m-4 c-12">
                <div class="policy-icon">
                    <i class="fa-regular fa-envelope-open"></i>
                    <span>Hỗ trợ khách hàng</span>
                </div>
            </div>
            <div class="col l-4 m-4 c-12">
                <div class="policy-icon">
                    <i class="fa-solid fa-truck"></i>
                    <span>Giao hàng</span>
                </div>
            </div>
            <div class="col l-4 m-4 c-12">
                <div class="policy-icon">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Bảo mật</span>
                </div>
            </div>
        </section>

    </main>

<script src="public/js/main.js"></script>

</body>
</html>
