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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="public/css/productDetail.css">
</head>

<body>
    <main>
        <section>
            <div class="grid wide container">
                <div class="row">
                    <div class="l-12">
                        <!--Chi tiết sản phẩm-->
                        <?php

                        if (!empty($listImages)) {
                            // Nếu $listImages không rỗng, tách chuỗi thành mảng
                            $list = explode(',', $listImages);
                        } else {
                            // Nếu $listImages rỗng, gán mảng trống
                            $list = [];
                        }

                        ?>
                        <div class="product-detail">
                            <div class="product-detail-thumbnails">
                                <?php
                                if (!empty($list)) {
                                    $count = count($list);
                                    for ($i = 0; $i < $count; $i++) {
                                        // in số lượng ảnh có trong mảng
                                        if (isset($list[$i])) {
                                            echo "<img src='public/image/{$list[$i]}' alt='Thumbnail " . ($i + 1) . "' class='thumbnail'>";
                                        }
                                    }
                                } else {
                                    echo '';
                                }
                                ?>
                            </div>
                            <img src="public/image/<?= $image ?>" alt="Tên sản phẩm">
                            <div class="info">
                                <h2><?= $name ?></h2>
                                <?php if (!empty($salePrice)) { ?>
                                    <p class="price"><?= number_format($salePrice) ?> đ</p>
                                    <p class="price"><del><?= number_format($price) ?> đ</del></p>
                                <?php } else { ?>
                                    <p class="price"><?= number_format($price) ?> </p>
                                <?php } ?>
                                <div class="quantity-controls">
                                    <button class="minus"><i class="fa-solid fa-minus"></i></button>
                                    <input type="text" id="amount" value="1">
                                    <button class="plus"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="description-product">
                                    <p><?= $description ?></p>
                                </div>
                                <div class="cart-button">
                                    <form action="index.php?page=addToCartInDetail" method="post"
                                        style=" display: contents;">
                                        <input type="hidden" name="product_quantity" class="amount" id="hidden_quantity"
                                            value="1">
                                        <input type="hidden" name="product_id" class="product_id" value="<?= $id ?>">
                                        <input type="hidden" name="product_name" value="<?= $name ?>">
                                        <input type="hidden" name="product_price" value="<?= $price ?>">
                                        <input type="hidden" name="product_image" value="<?= $image ?>">
                                        <input type="hidden" name="product_color" value="<?= $color ?>">
                                        <input type="hidden" name="product_quantity" value="1">
                                        <button type="submit" name="addToCartInDetail" class="addCart-product">Thêm vào
                                            giỏ hàng</button>
                                    </form>
                                    <!-- <button>Mua ngay</button> -->
                                </div>
                            </div>
                        </div>
                        <!-- Mô tả chi tiết sản phẩm-->
                        <div class="">
                            <h3 class="product-detail-title">Chi tiết sản phẩm</h3>
                            <p class="product-detail-description"><?= $detail ?></p>
                            <table class="product-detail-tables">
                            <tr>
                                <td>Loại sản phẩm: <?= $data['nameCate'][0]['name'] ?></td>
                            </tr>
                            <tr>
                                <td>Chất liệu: <?= $material ?></td>
                            </tr>
                            <tr>
                                <td>Kích thước: <?= $size ?></td>
                            </tr>
                            <tr>
                                <td>Màu sắc: <?= $color ?></td>
                            </tr>
                            </table>
                        </div>
                 


                    <div class="l-12">
                        <div class="review-section">
                            <h3 class="rating-title">Đánh giá</h3>
                            <div class="rating-summary">
                                <div class="average-rating">
                                    <?php
                                    $rating = $data['rating'];
                                    $totalStar = null;
                                    for ($i = 0; $i < count($rating); $i++) {
                                        $totalStar += (int) $rating[$i]['star'];
                                        $count = count($rating);
                                    }
                                    $count = count($rating);
                                    if ($count != 0) {
                                        $star = $totalStar / $count;

                                    } else {
                                        $star = 0;
                                    }
                                    ?>
                                    <p><?= round($star) ?></p>
                                    <p class="review-count">Của <?= $count ?> đánh giá</p>
                                    <span class="star-rating">
                                        <?php
                                        $star = round($star);
                                        if ($star == 1) {
                                            echo "
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            ";
                                        } elseif ($star == 2) {
                                            echo "
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            ";
                                        } elseif ($star == 3) {
                                            echo "
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            ";
                                        } elseif ($star == 4) {
                                            echo "
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            ";
                                        } elseif ($star == 5) {
                                            echo "
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            <i class='fa-solid fa-star'></i>
                                            ";
                                        } else {
                                            echo "
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            <i class='fa-regular fa-star'></i>
                                            "; // Trường hợp rating không nằm trong 1-5
                                        }
                                        ?>

                                    </span>
                                </div>

                                <div class="rating-distribution">
                                    <?php
                                    if ($star != 0) {


                                        $rate1 = 0;
                                        $rate2 = 0;
                                        $rate3 = 0;
                                        $rate4 = 0;
                                        $rate5 = 0;

                                        foreach ($rating as $item) {
                                            extract($item);
                                            if ($star == 1) {
                                                $rate1++;
                                            } else if ($star == 2) {
                                                $rate2++;
                                            } else if ($star == 3) {
                                                $rate3++;
                                            } else if ($star == 4) {
                                                $rate4++;
                                            } else {
                                                $rate5++;
                                            }
                                        }

                                        $sl = count($rating);
                                        $percent5 = ($rate5 / $sl) * 100;
                                        $percent4 = ($rate4 / $sl) * 100;
                                        $percent3 = ($rate3 / $sl) * 100;
                                        $percent2 = ($rate2 / $sl) * 100;
                                        $percent1 = ($rate1 / $sl) * 100;
                                        ?>
                                        
                                    <?php } else {
                                        echo "
                                    <div class='rating-bar'><span>Xuất sắc</span>
                                        <div class='bar'>
                                            <div class='fill' style='width:0%;'></div>
                                        </div><span>0</span>
                                    </div>
                                    <div class='rating-bar'><span>Tốt</span>
                                        <div class='bar'>
                                            <div class='fill' style='width:0%;'></div>
                                        </div><span>0</span>
                                    </div>
                                    <div class='rating-bar'><span>Trung bình</span>
                                        <div class='bar'>
                                            <div class='fill' style='width:0%;'></div>
                                        </div><span>0</span>
                                    </div>
                                    <div class='rating-bar'><span>Kém</span>
                                        <div class='bar'>
                                            <div class='fill' style='width:0%;'></div>
                                        </div><span>0</span>
                                    </div>
                                    <div class='rating-bar'><span>Rất kém</span>
                                        <div class='bar'>
                                            <div class='fill' style='width:0%;'></div>
                                        </div><span>0</span>
                                    </div>
                                    ";
                                    }

                                    ?>
                                </div>


                            </div>
                        </div>
                        <!-- Phần bình luận -->
                        <style lang="">
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
                                line-height: 1.5;
                                font-size: 17px;
                                border: 2px solid #8D6E6E;
                                padding: 10px;
                                border-radius: 5px;
                            }

                            .form-comment button {
                                background-color: #8D6E6E;
                                color: #FFFFFF;
                                border: none;
                                padding: 10px 20px;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 15px;
                                margin-top: 10px;
                            }
                        </style>
                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="POST" action="index.php?page=addComment" class="form-comment">
                                <p>Bình Luận</p>
                                <input type="hidden" name="idProduct" value="<?php echo $data['detail']['id']; ?>">
                                <textarea name="comment_text" placeholder="Nhập nội dung bình luận..." required></textarea>
                                <button type="submit">Gửi bình luận</button>
                            </form>
                        <?php else: ?>
                            <p>Bạn cần đăng nhập để bình luận.</p>
                        <?php endif; ?>
                        <!-- hiện bình luận -->
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
                            $slComment = count($data['comment']);
                            if ($slComment > 3) {
                                echo "
                                    <button class='load-more-btn'>Xem thêm
                                        <i class='fa-solid fa-chevron-down'></i>
                                    </button>
                                    ";
                            } else {
                                echo '';
                            }


                            ?>

                        </div>
                    </div>
                    <!-- Sản phẩm liên quan-->

                    <div class="col l-12">
                        <section class="row">
                            <div class="title-box">`
                                <h3>Sản phẩm liên quan</h3>
                            </div>
                            <div class="row">
                                <?php
                                $relatePro = $data['splq'];
                                foreach ($relatePro as $item) {
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
                                                        <?php if (!empty($salePrice)) { ?>
                                                            <span><?= number_format($salePrice) ?> đ</span>
                                                            <span> <sub><del><?= number_format($price) ?></del> đ</sub> </span>
                                                        <?php } else { ?>
                                                            <span><?= number_format($price) ?> đ</span>
                                                        <?php } ?>
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
</body>
<script src="public/js/product.js"> </script>