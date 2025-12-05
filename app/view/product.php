<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($data['nameCate']['name']) ? $data['nameCate']['name'] : 'Danh mục' ?>
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/prouduct.css">

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
        #toast-msg-fixed.success { background:#4CAF50; }
        #toast-msg-fixed.error { background:#E53935; }
        #toast-msg-fixed.hide { opacity:0; }
    </style>

</head>

<body>

<!-- ===== TOAST MESSAGE ===== -->
<?php if (!empty($_SESSION['cart_message'])): 
    $msg = $_SESSION['cart_message']; ?>
    <div id="toast-msg-fixed" class="<?= $msg['type'] ?>">
        <?= $msg['text']; ?>
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


<main>
    <section>
        <div class="grid wide container">
            <div class="row">

                <!-- Cột danh mục -->
                <div class="col l-3">
                    <div class="search-bar">
                        <form action="index.php?page=search" method="post">
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm">
                            <button name="submitSearch"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <h3 class="title"><?= $data['nameCate']['name'] ?? 'Danh mục' ?></h3>

                    <ul class="cateProduct">
                        <?php foreach ($data['cate'] as $item): ?>
                            <?php if ($item['status'] == 1): ?>
                                <li><a class="nameCate" href="index.php?page=product&id=<?= $item['id'] ?>">
                                    <?= $item['name'] ?>
                                </a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Cột sản phẩm -->
                <div class="col l-9">
                    <section class="row">

                        <?php foreach ($data['products'] as $item): ?>
                            <?php if ($item['status'] == 1): ?>
                                <div class="col l-4 m-4 c-12">
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

                                        <!-- FORM THÊM GIỎ HÀNG -->
                                        <form action="index.php?page=addToCart" method="post" class="addCart-product">
                                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="product_name" value="<?= $item['name'] ?>">
                                            <input type="hidden" name="product_price" value="<?= $item['price'] ?>">
                                            <input type="hidden" name="product_image" value="<?= $item['image'] ?>">

                                            <!-- idColor từ Model -->
                                            <input type="hidden" name="product_color" value="<?= $item['idColor'] ?>">

                                            <input type="hidden" name="product_quantity" value="1">

                                            <button type="submit" name="addToCart" class="addCart-product">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </section>
                </div>

            </div>
        </div>
    </section>
</main>

<script src="public/js/product.js"></script>

</body>
</html>
