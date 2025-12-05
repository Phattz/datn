<?php 
$product = $data['detail']; 
extract($product);

// Danh sách màu của sản phẩm
$colors = $data['colors'];

// Chọn màu mặc định = màu đầu tiên
$defaultColor = isset($colors[0]) ? $colors[0]['id'] : 0;

// Danh sách hình
$list = !empty($listImages) ? explode(',', $listImages) : [];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?></title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="public/css/productDetail.css">

    <!-- =========== TOAST CSS =========== -->
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
            opacity: 1;
            transition: opacity .4s ease;
        }
        #toast-msg-fixed.success { background:#4CAF50; }
        #toast-msg-fixed.error { background:#E53935; }
        #toast-msg-fixed.hide { opacity:0; }
    </style>
</head>

<body>

<!-- =========== TOAST MESSAGE =========== -->
<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
        <?= $_SESSION['cart_message']['text']; ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<script>
// Ẩn toast sau 2 giây
document.addEventListener("DOMContentLoaded", () => {
    const t = document.getElementById("toast-msg-fixed");
    if (t) {
        setTimeout(() => {
            t.classList.add("hide");
            setTimeout(() => t.remove(), 400);
        }, 2000);
    }
});
</script>
<!-- ===================================== -->


<main>
<section>
<div class="grid wide container">
<div class="row">

<div class="l-12">

    <div class="product-detail">

        <!-- Thumbnails -->
        <div class="product-detail-thumbnails">
            <?php foreach ($list as $img): ?>
                <img src="public/image/<?= $img ?>" class="thumbnail">
            <?php endforeach; ?>
        </div>

        <!-- Ảnh chính -->
        <img src="public/image/<?= $image ?>" alt="<?= $name ?>">

        <!-- INFO -->
        <div class="info">

            <h2><?= $name ?></h2>

            <p class="price"><?= number_format($price) ?> đ</p>

            <!-- SỐ LƯỢNG -->
            <div class="quantity-controls">
                <button class="minus"><i class="fa-solid fa-minus"></i></button>
                <input type="text" id="amount" value="1">
                <button class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>

            <!-- ========== CHỌN MÀU (AUTO CÓ MẶC ĐỊNH) ========== -->
            <div class="product-options" style="margin-top: 15px;">
                <label style="font-weight:600;font-size:16px;">Màu:</label>

                <div style="display:flex;gap:10px;flex-wrap:wrap;">

                    <?php foreach ($colors as $c): ?>
                        <?php $isDefault = ($c['id'] == $defaultColor); ?>

                        <label style="cursor:pointer;">

                            <input type="radio" 
                                   name="color"
                                   value="<?= $c['id'] ?>"
                                   <?= $isDefault ? 'checked' : '' ?>
                                   style="display:none;"
                                   onchange="resetOther(this)"
                            >

                            <span onclick="selectOption(this)"
                                  style="
                                        padding:8px 14px;
                                        border:2px solid <?= $isDefault ? '#8D6E6E' : '#ccc' ?>;
                                        background: <?= $isDefault ? '#8D6E6E' : '#fff' ?>;
                                        color: <?= $isDefault ? '#fff' : '#000' ?>;
                                        border-radius:8px;
                                        transition:0.2s;
                                  ">
                                <?= $c['nameColor'] ?>
                            </span>

                        </label>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- input ẩn để gửi màu -->
            <input type="hidden" id="selected_color" name="product_color" value="<?= $defaultColor ?>">

            <!-- MÔ TẢ -->
            <div class="description-product">
                <p><?= $description ?></p>
            </div>

            <!-- ========== BUTTON ADD CART ========== -->
            <div class="cart-button">

                <form action="index.php?page=addToCartInDetail" method="post" style="display:contents;">

                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <input type="hidden" name="product_name" value="<?= $name ?>">
                    <input type="hidden" name="product_price" value="<?= $price ?>">
                    <input type="hidden" name="product_image" value="<?= $image ?>">

                    <!-- SL -->
                    <input type="hidden" id="hidden_quantity" name="product_quantity" value="1">

                    <!-- MÀU -->
                    <input type="hidden" id="selected_color" name="product_color" value="<?= $defaultColor ?>">

                    <button type="submit" name="addToCartInDetail" class="addCart-product">
                        Thêm vào giỏ hàng
                    </button>
                </form>

            </div>
        </div><!-- END info -->

    </div><!-- END product-detail -->


    <!-- CHI TIẾT -->
    <h3 class="product-detail-title">Chi tiết sản phẩm</h3>
    <p class="product-detail-description"><?= $description ?></p>


    <!-- BÌNH LUẬN -->
    <div class="comment-section">
        <?php foreach ($data['comment'] as $c): ?>
            <div class="comment">
                <div class="user-avatar"></div>
                <div class="user-review">
                    <p class="user-name"><?= $c['name'] ?></p>
                    <p><?= $c['text'] ?></p>
                </div>
                <p class="comment-date"><?= $c['dateComment'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="center-button-container">
        <?php if (count($data['comment']) > 3): ?>
            <button class="load-more-btn">
                Xem thêm <i class="fa-solid fa-chevron-down"></i>
            </button>
        <?php endif; ?>
    </div>


    <!-- SẢN PHẨM LIÊN QUAN -->
    <div class="l-12">
        <section class="row">
            <div class="title-box">
                <h3>Sản phẩm liên quan</h3>
            </div>

            <div class="row">
                <?php foreach ($data['splq'] as $item): 
                    extract($item);
                    if ($status != 1) continue;
                ?>
                    <div class="col l-3 m-4 c-12">
                        <div class="product">
                            <a href="index.php?page=productDetail&id=<?= $id ?>">
                                <div class="img-product">
                                    <img src="public/image/<?= $image ?>">
                                </div>
                                <div class="name-product"><span><?= $name ?></span></div>
                                <p class="price"><?= number_format($price) ?> đ</p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </section>
    </div>

</div>
</div>
</div>
</section>
</main>


<!-- ========== JS: chọn màu ========== -->
<script>
document.querySelectorAll('input[name="color"]').forEach(radio => {
    radio.addEventListener('change', function(){
        document.getElementById('selected_color').value = this.value;
    });
});

function resetOther(inputElement) {
    document.querySelectorAll('input[name="color"]').forEach(el => {
        const span = el.nextElementSibling;
        span.style.background = "#fff";
        span.style.color = "#000";
        span.style.borderColor = "#ccc";
    });

    const span = inputElement.nextElementSibling;
    span.style.background = "#8D6E6E";
    span.style.color = "#fff";
    span.style.borderColor = "#8D6E6E";
}

function selectOption(span) {
    const input = span.previousElementSibling;
    input.checked = true;
    input.dispatchEvent(new Event("change"));
}
</script>

<script src="public/js/product.js"></script>

</body>
</html>
