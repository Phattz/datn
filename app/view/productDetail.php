<?php  
$product = $data['detail']; 
extract($product);

// Danh sách màu
$colors = $data['colors'];

// Màu mặc định
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="public/css/productDetail.css">

    <!-- Toast -->
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
            z-index: 99999;
            transition: opacity .4s ease;
        }
        #toast-msg-fixed.success { background:#4CAF50; }
        #toast-msg-fixed.error { background:#E53935; }
        #toast-msg-fixed.hide { opacity:0; }

        .color-option.active {
            background: #8D6E6E !important;
            color: #fff !important;
            border-color: #8D6E6E !important;
        }
    </style>
</head>

<body>

<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
        <?= $_SESSION['cart_message']['text']; ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("toast-msg-fixed");
    if (el) {
        setTimeout(() => el.classList.add("hide"), 1600);
        setTimeout(() => el.remove(), 2000);
    }
});
</script>

<main>
<section>
<div class="grid wide container">
<div class="row">

<div class="l-12">

    <div class="product-detail">

        <!-- THUMBNAILS -->
        <div class="product-detail-thumbnails">
            <?php foreach ($list as $img): ?>
                <img src="public/image/<?= $img ?>" class="thumbnail">
            <?php endforeach; ?>
        </div>

        <!-- ẢNH CHÍNH -->
        <img src="public/image/<?= $image ?>" alt="<?= $name ?>">

        <!-- INFO -->
        <div class="info">

            <h2><?= $name ?></h2>
            <p class="price"><?= number_format($price) ?> đ</p>

            <!-- SỐ LƯỢNG -->
            <div class="quantity-controls">
                <button class="minus"><i class="fa-solid fa-minus"></i></button>
                <input type="text" id="amount" value="1" max="99">
                <button class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>

            <!-- CHỌN MÀU -->
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
                                   hidden>

                            <span class="color-option <?= $isDefault ? 'active' : '' ?>">
                                <?= $c['nameColor'] ?>
                            </span>
                        </label>

                    <?php endforeach; ?>
                </div>
            </div>

            <!-- MÔ TẢ -->
            <div class="description-product">
                <p><?= $description ?></p>
            </div>

            <!-- ADD CART -->
            <div class="cart-button">
                <form action="index.php?page=addToCartInDetail" method="post" style="display:contents;">

                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <input type="hidden" name="product_price" value="<?= $price ?>">
                    <input type="hidden" name="product_image" value="<?= $image ?>">

                    <input type="hidden" id="hidden_quantity" name="product_quantity" value="1">

                    <!-- input màu gửi vào cart -->
                    <input type="hidden" id="final_color" name="product_color" value="<?= $defaultColor ?>">

                    <button type="submit" name="addToCartInDetail" class="addCart-product">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>

        </div>
    </div>

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
</div></div></div>
</section>
</main>

<!-- JS XỬ LÝ MÀU + SỐ LƯỢNG -->
<script>
let productId = <?= $id ?>;

const amount = document.getElementById("amount");
const hidden_quantity = document.getElementById("hidden_quantity");

// =============================
// CHỌN MÀU
// =============================
document.querySelectorAll('input[name="color"]').forEach(radio => {
    radio.addEventListener('change', async function () {

        const colorId = this.value;
        document.getElementById("final_color").value = colorId;

        document.querySelectorAll(".color-option").forEach(s => s.classList.remove("active"));
        this.nextElementSibling.classList.add("active");

        const res = await fetch("index.php?page=checkQuantity", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                proId: productId,
                colorId: colorId
            })
        });

        const data = await res.json();
        const stock = parseInt(data.quantity);

        amount.value = 1;
        amount.max = stock;
        hidden_quantity.value = 1;

        if (stock === 0) {
            alert("Màu này đã hết hàng!");
        }
    });
});

// =============================
// TĂNG GIẢM SỐ LƯỢNG
// =============================
document.querySelector(".plus").addEventListener("click", function(){
    let val = parseInt(amount.value);
    let max = parseInt(amount.max || 99);

    if (val < max) {
        amount.value = val + 1;
        hidden_quantity.value = val + 1;
    }
});

document.querySelector(".minus").addEventListener("click", function(){
    let val = parseInt(amount.value);
    if (val > 1) {
        amount.value = val - 1;
        hidden_quantity.value = val - 1;
    }
});
</script>


</body>
</html>
