
<?php  
$product = $data['detail']; 
$userName = "";
if (!empty($_SESSION['user'])) {
    $userModel = new UserModel();
    $u = $userModel->getUserById($_SESSION['user']);
    $userName = $u['name'];
}
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
        .user-name {
            font-size: 16px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .comment-text {
            margin: 0 0 5px 0;
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
    <input type="number" id="amount" name="quantity" value="1" min="1" max="<?= $detail['stockQuantity'] ?>">
    <button class="plus"><i class="fa-solid fa-plus"></i></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const hiddenQuantity = document.getElementById('hidden_quantity');

    // Kiểm tra ngay khi nhập
    amountInput.addEventListener('input', function() {
        let value = parseInt(amountInput.value);
        let min = parseInt(amountInput.min);
        let max = parseInt(amountInput.max);

        if (isNaN(value) || amountInput.value.trim() === "") {
            return; // cho phép tạm thời rỗng khi đang gõ
        }

        if (value < min) {
            alert("Số lượng không được nhỏ hơn " + min);
            amountInput.value = min;
        } else if (value > max) {
            alert("Số lượng vượt quá tồn kho (" + max + ")");
            amountInput.value = max;
        }

        hiddenQuantity.value = amountInput.value;
    });

    // Đồng bộ trước khi submit form
    const form = document.querySelector('.cart-button form');
    form.addEventListener('submit', function() {
        if (amountInput.value.trim() === "" || isNaN(parseInt(amountInput.value))) {
            amountInput.value = amountInput.min; // nếu để trống thì ép về min
        }
        hiddenQuantity.value = amountInput.value;
    });
});
</script>




            <!-- CHỌN MÀU -->
            <div class="product-options" style="margin-top: 15px;">
                <label style="font-weight:600;font-size:25px;">Màu:</label>

                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top: 5px;">
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
    

<!-- ====== KHỐI ĐÁNH GIÁ SẢN PHẨM ====== -->



<div class="product-rating-section rating-box">
    <?php if (!empty($ratingInfo) && $ratingInfo['totalRating'] > 0): ?>

    <?php 
        $avg = round($ratingInfo['avgStar'] ?? 0, 1);
        $total = $ratingInfo['totalRating'] ?? 0;
        $percent = ($avg / 5) * 100;
    ?>
    <div class="rating-summary">
    <div class="rating-stars-avg">
        <div class="stars-bg">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
        </div>

        <div class="stars-fill" style="width: <?= ($ratingInfo['avgStar'] ?? 0) / 5 * 100 ?>%;">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
        </div>
    </div>

        <span class="rating-number"><?= round($ratingInfo['avgStar'],1) ?></span>
        <span class="rating-slash">/</span>
        <span class="rating-max">5</span>
        <i class="fa-solid fa-star rating-max-star"></i>
        <span class="rating-total">(<?= $ratingInfo['totalRating'] ?> đánh giá)</span>
    </div>



<?php else: ?>
    <p>Chưa có đánh giá nào</p>
<?php endif; ?>

</div>

    <?php
        $ratingList = $data['ratingPage'] ?? [];
        $ratingAll  = $data['ratingAll']  ?? [];
        $ratingInfo = $data['ratingInfo'] ?? [];
        ?>
    <?php
$total = $totalRating ?? 0;

// Khởi tạo dữ liệu rỗng cho 5 → 1 sao
$starCount = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0
];

// ratingStats là dạng nhiều dòng → convert về dạng key-value
foreach ($ratingStats as $row) {
    $star = (int)$row['ratingStar'];
    $count = (int)$row['total'];

    if (isset($starCount[$star])) {
        $starCount[$star] = $count;
    }
}
?>




<div id="ratingSection">
    <?php foreach ($data['ratingPage'] ?? [] as $r): ?>
<div class="rating-item rating-item-box">
    <div class="rating-header">
    <div class="rating-left">
        <strong class="rating-username"><?= htmlspecialchars($r['userName']); ?></strong>
        <span class="rating-color">Màu: <?= htmlspecialchars($r['colorName']); ?></span>
    </div>

    <div class="rating-date-block">
        <span class="rating-date-label">Ngày đánh giá:</span>
        <span class="rating-date-value"><?= $r['dateRate']; ?></span>
    </div>
</div>

    <p class="reviewContent"><?= htmlspecialchars($r['reviewContent']); ?></p>

    <div class="rating-stars">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="fa-solid fa-star <?= $i <= $r['ratingStar'] ? 'active-star' : '' ?>"></i>
        <?php endfor; ?>
    </div>
</div>
<?php endforeach; ?>

</div>

        

    <?php if (!empty($totalPages) && $totalPages > 1): ?>
    <div class="rating-pagination">

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=productDetail&id=<?= $detail['id'] ?>&pageRate=<?= $i ?>"
        class="page-number <?= $i == $currentPage ? 'active' : '' ?>">
            <?= $i ?>
        </a>

                <?php endfor; ?>

            </div>
        <?php endif; ?>



</div>



</div>

<!-- BÌNH LUẬN -->
<div class="comment-wrapper">
    <h3>Bình luận:</h3>

    <div class="comment-section">
        <?php if (!empty($data['comments'])): ?>
            <?php foreach ($data['comments'] as $c): ?>
                <div class="comment">
                    <div class="user-review">
                        <p class="user-name">
                            <strong><?= !empty($c['userName']) ? $c['userName'] : $c['guestName'] ?></strong>
                        </p>
                        <p class="comment-text"><?= $c['text'] ?></p>
                    </div>
                    <div class="rating-date-block">
        <span class="comment-date-label">Ngày bình luận:</span>
        <span class="comment-date"><?= $c['dateComment']; ?></span>
    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có bình luận nào.</p>
        <?php endif; ?>
    </div>

    <!-- FORM GỬI BÌNH LUẬN -->
    <div class="comment-form">
        <h3 class="comment-title">Viết bình luận</h3>

        <form action="index.php?page=addComment" method="post">
    <input type="hidden" name="idProduct" value="<?= $id ?>">

    <!-- HIỂN THỊ TÊN (KHÔNG CHO SỬA) -->
    <div class="user-name">
        <?php if (!empty($_SESSION['user'])): ?>
            <?= htmlspecialchars($userName) ?>
            <input type="hidden" name="idUser" value="<?= $_SESSION['user'] ?>">
        <?php else: ?>
            Khách vãn lai
        <?php endif; ?>
    </div>

    <!-- NỘI DUNG BÌNH LUẬN -->
    <label for="commentText">Bình luận:</label>
    <textarea id="commentText"
        name="text"
        class="comment-textarea"
        required
        placeholder="Nhập nội dung bình luận..."></textarea>

    <button type="submit" name="sendComment" class="comment-submit">
        Gửi bình luận
    </button>
</form>
    </div>
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


<script>
    const CURRENT_PRODUCT_ID = <?= (int)$detail['id']; ?>;
</script>
<!-- JS XỬ LÝ MÀU + SỐ LƯỢNG -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("showMoreRating");
    const more = document.getElementById("ratingMore");

    if (btn) {
        btn.addEventListener("click", function() {
            more.style.display = "block";
            btn.style.display = "none";
        });
    }
});
// Lưu vị trí scroll trước khi load trang mới
document.querySelectorAll(".page-number").forEach(link => {
    link.addEventListener("click", function () {
        localStorage.setItem("scrollPos", window.scrollY);
    });
});

// Khôi phục vị trí scroll sau khi reload
document.addEventListener("DOMContentLoaded", function () {
    const pos = localStorage.getItem("scrollPos");
    if (pos !== null) {
        window.scrollTo(0, parseInt(pos));
        localStorage.removeItem("scrollPos");
    }
});
</script>
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
    proId: CURRENT_PRODUCT_ID,
    colorId: colorId
})
        });

        const data = await res.json();
        console.log("API trả về:", data);

        // 🚀 Cập nhật GIÁ theo màu
        if (data.price) {
            const formattedPrice = Number(data.price).toLocaleString('vi-VN');
            document.querySelector(".price").textContent = formattedPrice + " đ";
        }

        // 🚀 Cập nhật tồn kho
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
