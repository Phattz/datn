<?php 
$product = $data['detail']; 
extract($product); 
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
</head>

<body>

<main>
<section>
<div class="grid wide container">
<div class="row">

<div class="l-12">

    <!-- Chi tiết sản phẩm -->
    <?php
    if (!empty($listImages)) {
        $list = explode(',', $listImages);
    } else {
        $list = [];
    }
    ?>

    <div class="product-detail">

        <!-- Thumbnails -->
        <div class="product-detail-thumbnails">
            <?php 
            if (!empty($list)) {
                $count = count($list);
                for ($i = 0; $i < $count; $i++) {
                    if (isset($list[$i])) {
                        echo "<img src='public/image/{$list[$i]}' 
                                  alt='Thumbnail " . ($i + 1) . "' 
                                  class='thumbnail'>";
                    }
                }
            }
            ?>
        </div>

        <!-- Ảnh chính -->
        <img src="public/image/<?= $image ?>" alt="Tên sản phẩm">

        <!-- Info -->
        <div class="info">

            <h2><?= $name ?></h2>

            <p class="price"><?= number_format($price) ?></p>

            <!-- Số lượng -->
            <div class="quantity-controls">
                <button class="minus"><i class="fa-solid fa-minus"></i></button>
                <input type="text" id="amount" value="1">
                <button class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>
            <!-- CHỌN SIZE -->
<div class="product-options" style="margin-top: 15px;">
    <label style="font-weight: 600; font-size: 16px; display: block; margin-bottom: 8px;">
        Size:
    </label>

    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($data['sizes'] as $size): ?>
            <label 
                style="
                    position: relative;
                    cursor: pointer;
                "
            >
                <input 
                    type="radio" 
                    name="size" 
                    value="<?= $size['id'] ?>" 
                    style="display:none;"
                    onchange="this.nextElementSibling.style.borderColor='#8D6E6E'; this.nextElementSibling.style.background='#8D6E6E'; this.nextElementSibling.style.color='#fff'; resetOther(this);"
                >
                
                <span
                    style="
                        display:inline-block;
                        padding: 8px 14px;
                        border: 2px solid #ccc;
                        border-radius: 8px;
                        font-size: 15px;
                        transition: 0.15s;
                        user-select: none;
                    "
                    onclick="selectOption(this)"
                >
                    <?= $size['nameSize'] ?>
                </span>
            </label>
        <?php endforeach; ?>
    </div>
</div>

<!-- CHỌN MÀU -->
<div class="product-options" style="margin-top: 15px;">
    <label style="font-weight: 600; font-size: 16px; display: block; margin-bottom: 8px;">
        Màu:
    </label>

    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($data['colors'] as $color): ?>
            <label 
                style="
                    position: relative;
                    cursor: pointer;
                "
            >
                <input 
                    type="radio" 
                    name="color" 
                    value="<?= $color['id'] ?>" 
                    style="display:none;"
                    onchange="this.nextElementSibling.style.borderColor='#8D6E6E'; this.nextElementSibling.style.background='#8D6E6E'; this.nextElementSibling.style.color='#fff'; resetOther(this);"
                >
                
                <span
                    style="
                        display:inline-block;
                        padding: 8px 14px;
                        border: 2px solid #ccc;
                        border-radius: 8px;
                        font-size: 15px;
                        transition: 0.15s;
                        user-select: none;
                    "
                    onclick="selectOption(this)"
                >
                    <?= $color['nameColor'] ?>
                </span>
            </label>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Reset các ô khác về trạng thái mặc định
    function resetOther(inputElement) {
        const name = inputElement.name;

        document.querySelectorAll(`input[name="${name}"]`).forEach(el => {
            if (el !== inputElement) {
                const span = el.nextElementSibling;
                span.style.borderColor = "#ccc";
                span.style.background = "white";
                span.style.color = "black";
            }
        });
    }

    // Khi click vào span, trigger input radio
    function selectOption(span) {
        const input = span.previousElementSibling;
        input.checked = true;
        input.dispatchEvent(new Event("change"));
    }
</script>



            <!-- Mô tả -->
            <div class="description-product">
                <p><?= $description ?></p>
            </div>

            <!-- Thêm vào giỏ -->
            <div class="cart-button">

                <form action="index.php?page=addToCartInDetail"
                      method="post"
                      style="display: contents;">

                    <input type="hidden" id="hidden_quantity" 
                           name="product_quantity"
                           class="amount"
                           value="1">

                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <input type="hidden" name="product_name" value="<?= $name ?>">
                    <input type="hidden" name="product_price" value="<?= $price ?>">
                    <input type="hidden" name="product_image" value="<?= $image ?>">
                    <input type="hidden" name="product_color" value="<?= $color ?>">

                    <input type="hidden" name="product_quantity" value="1">

                    <button type="submit" 
                            name="addToCartInDetail" 
                            class="addCart-product">
                        Thêm vào giỏ hàng
                    </button>
                </form>

            </div>
        </div> <!-- end info -->

    </div> <!-- end product-detail -->


    <!-- Mô tả chi tiết -->
    <div>
        <h3 class="product-detail-title">Chi tiết sản phẩm</h3>
        <p class="product-detail-description"><?= $description ?></p>
    </div>


    <!-- Đánh giá -->
    <div class="l-12">
    <div class="review-section">

        <h3 class="rating-title">Đánh giá</h3>

        <div class="rating-summary">

            <div class="average-rating">
                <?php
                $rating = $data['rating'];
                $totalStar = 0;
                $count = count($rating);

                foreach ($rating as $r) {
                    $totalStar += (int)$r['star'];
                }

                $star = ($count > 0) ? $totalStar / $count : 0;
                $starRounded = round($star);
                ?>

                <p><?= $starRounded ?></p>
                <p class="review-count">Của <?= $count ?> đánh giá</p>

                <span class="star-rating">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $starRounded
                            ? "<i class='fa-solid fa-star'></i>"
                            : "<i class='fa-regular fa-star'></i>";
                    }
                    ?>
                </span>

            </div>

            <!-- Biểu đồ rating -->
            <div class="rating-distribution">

                <?php
                if ($count == 0) {
                    echo "
                        <div class='rating-bar'><span>Xuất sắc</span><div class='bar'><div class='fill' style='width:0%'></div></div><span>0</span></div>
                        <div class='rating-bar'><span>Tốt</span><div class='bar'><div class='fill' style='width:0%'></div></div><span>0</span></div>
                        <div class='rating-bar'><span>Trung bình</span><div class='bar'><div class='fill' style='width:0%'></div></div><span>0</span></div>
                        <div class='rating-bar'><span>Kém</span><div class='bar'><div class='fill' style='width:0%'></div></div><span>0</span></div>
                        <div class='rating-bar'><span>Rất kém</span><div class='bar'><div class='fill' style='width:0%'></div></div><span>0</span></div>
                    ";
                }
                ?>
            </div>

        </div>
    </div>
    </div>


    <!-- Bình luận -->
    <style>
        .form-comment {
            width: 1225px;
            text-align: right;
        }
        .form-comment p {
            font-weight: 700;
            font-size: 21px;
            margin-left: 10px;
            margin-bottom: 20px;
            text-align: left;
        }
        .form-comment textarea {
            width: 1224px;
            font-size: 17px;
            border: 2px solid #8D6E6E;
            padding: 10px;
            border-radius: 5px;
            line-height: 1.5;
        }
        .form-comment button {
            background-color: #8D6E6E;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 15px;
        }
    </style>

    <?php if (isset($_SESSION['user'])): ?>

        <form method="POST" action="index.php?page=addComment"
              class="form-comment">

            <p>Bình Luận</p>

            <input type="hidden" 
                   name="idProduct" 
                   value="<?= $data['detail']['id'] ?>">

            <textarea name="comment_text"
                      placeholder="Nhập nội dung bình luận..."
                      required></textarea>

            <button type="submit">Gửi bình luận</button>

        </form>

    <?php else: ?>

        <p>Bạn cần đăng nhập để bình luận.</p>

    <?php endif; ?>


    <!-- Hiển thị bình luận -->
    <div class="comment-section">
        <?php
        $comment = $data['comment'];
        foreach ($comment as $item) {
            extract($item);
            ?>
            <div class="comment">
                <div class="user-avatar"></div>
                <div class="user-review">
                    <p class="user-name"><?= $name ?></p>
                    <p><?= $text ?></p>
                </div>
                <p class="comment-date"><?= $dateProComment ?></p>
            </div>
        <?php } ?>
    </div>

    <div class="center-button-container">
        <?php 
        if (count($data['comment']) > 3) {
            echo "
                <button class='load-more-btn'>
                    Xem thêm <i class='fa-solid fa-chevron-down'></i>
                </button>
            ";
        }
        ?>
    </div>


    <!-- Sản phẩm liên quan -->
    <div class="col l-12">
        <section class="row">

            <div class="title-box">
                <h3>Sản phẩm liên quan</h3>
            </div>

            <div class="row">
                <?php
                foreach ($data['splq'] as $item) {
                    extract($item);

                    if ($status == 1) {
                ?>
                    <div class="col l-3 m-4 c-12">
                        <div class="product">

                            <a href="index.php?page=productDetail&id=<?= $id ?>">

                                <div class="img-product">
                                    <img src="public/image/<?= $image ?>" alt="">
                                </div>

                                <div class="name-product">
                                    <span><?= $name ?></span>
                                </div>

                                <div class="price-product">
                                <p class="price"><?= number_format($price) ?></p>
                                </div>

                            </a>

                            <button class="addCart-product">Thêm vào giỏ hàng</button>

                            <button class="heart-button" data-id="<?= $id ?>">
                                <i class="icon on fa-solid fa-heart"></i>
                                <i class="icon off fa-regular fa-heart"></i>
                            </button>

                        </div>
                    </div>
                <?php 
                    } 
                } 
                ?>
            </div>

        </section>
    </div>

</div>
</div>
</div>
</section>
</main>
<script>
const variants = <?= json_encode($data['variants']) ?>;
</script>

<script src="public/js/product.js"></script>
        

</body>
</html>
